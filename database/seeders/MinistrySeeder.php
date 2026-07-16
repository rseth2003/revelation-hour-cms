<?php

namespace Database\Seeders;

use App\Models\Ministry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MinistrySeeder extends Seeder
{
    public function run(): void
    {
        $ministries = [
            ['Prayer Ministry', 'Intercession, prayer gatherings and spiritual support.'],
            ['Worship Ministry', 'Leading people into God’s presence through worship and music.'],
            ['Youth and Young Adults', 'Equipping young people in faith, purpose and leadership.'],
            ['Children’s Ministry', 'Helping children know Jesus in a safe and joyful environment.'],
            ['Women and Families', 'Encouraging women and strengthening homes.'],
            ['Evangelism and Outreach', 'Sharing the Gospel and serving communities.'],
        ];

        foreach ($ministries as $index => [$name, $summary]) {
            Ministry::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'short_description' => $summary,
                    'description' => $summary,
                    'is_published' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
