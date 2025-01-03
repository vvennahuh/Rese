<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ReservationReminder;
use App\Models\Reservation;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $reservations = Reservation::whereDate('date', today())->get();

        foreach ($reservations as $reservation) {
            \Mail::to($reservation->user->email)->send(new ReservationReminder($reservation));
        }
    }
}
