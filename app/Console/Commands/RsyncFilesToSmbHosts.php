<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SmbHost;
use Illuminate\Support\Facades\Storage;

class RsyncFilesToSmbHosts extends Command
{
    protected $signature = 'app:rsync-files-to-smb-hosts';
    protected $description = 'Rsync files to SMB hosts';

    public function handle()
    {
        $smbHosts = SmbHost::all();

        foreach ($smbHosts as $smbHost) {
            $this->info("Rsyncing files to SMB host: {$smbHost->name}");

            $localPath = storage_path('app/public/uploads');
            $remotePath = "{$smbHost->username}@{$smbHost->host}:{$smbHost->remote_path}";

            $command = "rsync -avz --delete {$localPath}/ {$remotePath}";

            $output = null;
            $returnVar = null;
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                $this->info("Files successfully rsynced to {$smbHost->name}");
            } else {
                $this->error("Failed to rsync files to {$smbHost->name}");
            }
        }
    }
}
