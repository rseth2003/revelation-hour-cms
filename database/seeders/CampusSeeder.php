<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    public function run(): void
    {
        Campus::firstOrCreate(
            ['slug' => 'main-campus'],
            [
                'name' => 'Main Campus',
                'short_description' => 'The main home of Revelation Hour Ministries International.',
                'description' => 'Welcome to the main campus of Revelation Hour Ministries International.',
                'address' => 'Valley Road, Canaansite Estate, Nakwero Gayaza',
                'district' => 'Wakiso',
                'country' => 'Uganda',
                'phone_primary' => '+256 774 328 127',
                'phone_secondary' => '+256 784 537 003',
                'service_times' => "Tuesday Bible Study Service: 6:00 PM to 8:00 PM\nThursday MCS: 7:30 PM\nFriday Camp Meeting: 6:00 PM to 10:00 PM\nSunday Business Service: 9:00 AM to 11:00 AM\nSunday Service: 11:00 AM to 1:00 PM",
                'is_main_campus' => true,
                'is_published' => true,
                'sort_order' => 1,
            ]
        );
    }
}
