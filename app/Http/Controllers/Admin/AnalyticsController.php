<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $now = now();
        $monthStart = $now->copy()->startOfMonth();
        $yearStart = $now->copy()->startOfYear();

        $memberCount = $this->countTable('members');
        $activeMembers = $this->countWhere('members', 'membership_status', 'active');
        $visitors = $this->countWhere('members', 'membership_type', 'visitor');
        $newThisMonth = $this->countSince('members', 'created_at', $monthStart);
        $newThisYear = $this->countSince('members', 'created_at', $yearStart);
        $baptized = $this->countWhere('members', 'is_baptized', 1);
        $bornAgain = $this->countWhere('members', 'is_born_again', 1);

        $campusCount = $this->countTable('campuses');
        $ministryCount = $this->countTable('ministries');
        $eventCount = $this->countTable('events');
        $upcomingEvents = $this->upcomingEvents();
        $prayerRequests = $this->countTable('prayer_requests');
        $communicationMessages = $this->countTable('communication_messages');
        $preparedRecipients = $this->countTable('communication_recipients');

        $membershipTypes = $this->groupCounts('members', 'membership_type');
        $membershipStatuses = $this->groupCounts('members', 'membership_status');
        $genderCounts = $this->groupCounts('members', 'gender');

        $campusGrowth = $this->relationCounts(
            'members',
            'campuses',
            'campus_id',
            'name'
        );

        $ministryGrowth = $this->relationCounts(
            'members',
            'ministries',
            'ministry_id',
            'name'
        );

        $monthlyGrowth = $this->monthlyMemberGrowth();

        $recentMembers = Schema::hasTable('members')
            ? DB::table('members')
                ->select('id', 'first_name', 'last_name', 'membership_type', 'membership_status', 'created_at')
                ->latest('created_at')
                ->limit(8)
                ->get()
            : collect();

        $recentEvents = Schema::hasTable('events')
            ? DB::table('events')
                ->select('id', 'title', 'event_date', 'location', 'is_published')
                ->orderByDesc('event_date')
                ->limit(6)
                ->get()
            : collect();

        return view('admin.analytics.index', compact(
            'memberCount',
            'activeMembers',
            'visitors',
            'newThisMonth',
            'newThisYear',
            'baptized',
            'bornAgain',
            'campusCount',
            'ministryCount',
            'eventCount',
            'upcomingEvents',
            'prayerRequests',
            'communicationMessages',
            'preparedRecipients',
            'membershipTypes',
            'membershipStatuses',
            'genderCounts',
            'campusGrowth',
            'ministryGrowth',
            'monthlyGrowth',
            'recentMembers',
            'recentEvents'
        ));
    }

    private function countTable(string $table): int
    {
        return Schema::hasTable($table) ? DB::table($table)->count() : 0;
    }

    private function countWhere(string $table, string $column, mixed $value): int
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return 0;
        }

        return DB::table($table)->where($column, $value)->count();
    }

    private function countSince(string $table, string $column, Carbon $date): int
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return 0;
        }

        return DB::table($table)->where($column, '>=', $date)->count();
    }

    private function upcomingEvents(): int
    {
        if (! Schema::hasTable('events') || ! Schema::hasColumn('events', 'event_date')) {
            return 0;
        }

        return DB::table('events')->where('event_date', '>=', now())->count();
    }

    private function groupCounts(string $table, string $column): array
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return [];
        }

        return DB::table($table)
            ->select($column, DB::raw('COUNT(*) as total'))
            ->whereNotNull($column)
            ->groupBy($column)
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn ($row) => [(string) $row->{$column} => (int) $row->total])
            ->all();
    }

    private function relationCounts(
        string $sourceTable,
        string $relationTable,
        string $foreignKey,
        string $labelColumn
    ): array {
        if (
            ! Schema::hasTable($sourceTable)
            || ! Schema::hasTable($relationTable)
            || ! Schema::hasColumn($sourceTable, $foreignKey)
            || ! Schema::hasColumn($relationTable, $labelColumn)
        ) {
            return [];
        }

        return DB::table($relationTable)
            ->leftJoin($sourceTable, "{$sourceTable}.{$foreignKey}", '=', "{$relationTable}.id")
            ->select("{$relationTable}.{$labelColumn} as label", DB::raw("COUNT({$sourceTable}.id) as total"))
            ->groupBy("{$relationTable}.id", "{$relationTable}.{$labelColumn}")
            ->orderByDesc('total')
            ->limit(8)
            ->get()
            ->map(fn ($row) => ['label' => $row->label, 'total' => (int) $row->total])
            ->all();
    }

    private function monthlyMemberGrowth(): array
    {
        if (! Schema::hasTable('members') || ! Schema::hasColumn('members', 'created_at')) {
            return [];
        }

        $months = collect(range(5, 0))->map(function ($offset) {
            $date = now()->subMonths($offset);
            return [
                'key' => $date->format('Y-m'),
                'label' => $date->format('M'),
                'start' => $date->copy()->startOfMonth(),
                'end' => $date->copy()->endOfMonth(),
            ];
        });

        return $months->map(function ($month) {
            return [
                'label' => $month['label'],
                'total' => DB::table('members')
                    ->whereBetween('created_at', [$month['start'], $month['end']])
                    ->count(),
            ];
        })->all();
    }
}
