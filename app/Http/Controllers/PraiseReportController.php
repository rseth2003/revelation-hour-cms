<?php

namespace App\Http\Controllers;

use App\Models\PraiseReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PraiseReportController extends Controller
{
    public function index(Request $request): View
    {
        $reports = PraiseReport::query()->where('status','published')
            ->when($request->filled('category'), fn($q) => $q->where('category',$request->string('category')))
            ->when($request->filled('q'), fn($q) => $q->where(fn($s) => $s->where('title','like','%'.$request->string('q').'%')->orWhere('testimony','like','%'.$request->string('q').'%')))
            ->orderByDesc('is_featured')->orderBy('sort_order')->orderByDesc('testimony_date')->paginate(9)->withQueryString();
        $categories = PraiseReport::query()->where('status','published')->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
        return view('pages.praise-reports', compact('reports','categories'));
    }

    public function show(PraiseReport $praiseReport): View
    {
        abort_unless($praiseReport->status === 'published', 404);
        $praiseReport->load(['approvedComments']);
        $reactionCounts = $praiseReport->reactions()
            ->selectRaw('reaction, COUNT(*) as total')
            ->groupBy('reaction')
            ->pluck('total', 'reaction');

        return view('pages.praise-report-show', compact('praiseReport', 'reactionCounts'));
    }
}
