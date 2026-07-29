<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (AppSetting::defaults() as $key => $value) {
            AppSetting::query()->firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
