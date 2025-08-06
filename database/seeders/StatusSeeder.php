<?php

namespace Database\Seeders;

use App\Helpers\Status as StatusEnum;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach (StatusEnum::withColors() as $slug => $color) {
            Status::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => Str::headline(str_replace('_', ' ', $slug)),
                    'color' => $color,
                    'is_active' => true,
                ]
            );
        }
    }
}
