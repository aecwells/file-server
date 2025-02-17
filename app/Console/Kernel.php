<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\ListFiles::class,
        Commands\DeleteFile::class,
        Commands\ForceDeleteFile::class,
        Commands\RemoveFileAssociation::class,
        Commands\ListGroupedFiles::class,
        Commands\ListAllFiles::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // ...existing code...
    }

    protected function commands()
    {
        // ...existing code...
    }
}
