<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Website;
use App\Jobs\CheckWebsiteStatusJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::call(function () {
    Website::query()->chunk(50, function ($websites) {
        foreach ($websites as $website) {
            CheckWebsiteStatusJob::dispatch($website);
        }
    });
})->everyFifteenMinutes();