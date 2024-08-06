<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckAlertBookingConfirmSale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:alert-booking-confirm-sale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check alert booking confirm sale at 17:30 every day';

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
        Http::get(url('/alert/booking/sale'));

        $this->info('Alert booking confirm sale checked successfully.');
        return 0;
    }
}
