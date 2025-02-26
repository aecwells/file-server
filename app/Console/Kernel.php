<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\RsyncFilesToSmbHosts;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\ListFiles::class,
        Commands\DeleteFile::class,
        Commands\ForceDeleteFile::class,
        Commands\RemoveFileAssociation::class,
        Commands\ListGroupedFiles::class,
        Commands\ListAllFiles::class,
        Commands\ListCollections::class, // Add the new command here
        Commands\RsyncFilesToSmbHosts::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // ...existing code...
        $schedule->command('app:rsync-files-to-smb-hosts')->daily();
        // ...existing code...
    }

    protected function commands()
    {
        // ...existing code...
    }
}
