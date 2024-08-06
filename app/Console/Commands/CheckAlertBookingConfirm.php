<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckAlertBookingConfirm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:alert-booking-confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check alert booking confirm every hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Call the route
        $url = route('alert.booking');
        Http::get($url);


        $this->info('Alert booking confirm checked successfully.');
        return 0;
    }
}
