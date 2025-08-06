<?php

namespace Database\Seeders;

use App\Helpers\StoryPoint as StoryPointHelper;
use App\Models\StoryPoint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoryPointSeeder extends Seeder
{
    public function run(): void
    {
        foreach (StoryPointHelper::withDetails() as $data) {
            StoryPoint::create([
                'id' => (string) Str::uuid(),
                'name' => $data['name'],
                'value' => $data['value'],
                'hours' => $data['hours'],
                'is_active' => true,
            ]);
        }
    }
}
