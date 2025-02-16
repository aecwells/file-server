<?php

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Activity::saving(function (Activity $activity) {
            Log::info("Activity logged: " . json_encode($activity->toArray()));
        });
    }
}