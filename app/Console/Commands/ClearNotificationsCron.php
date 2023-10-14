<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notifications;

class ClearNotificationsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear_notifications:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear 2 months old notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reports = Notifications::where( 'created_at', '<', now()->subDays(60))->delete();
    }
}
