<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AlertBeforeBookingConfirmSale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:before-booking-confirm-sale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert before booking confirm sale at 16:30 every day';

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
        $url = route('alert.booking.bf.sale');
        Http::get($url);

        $this->info('Alert before booking confirm sale executed successfully.');
        return 0;
    }
}
