<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessDuplicatedFundEntry implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $fund = $event->fund;
        $duplicated = $event->duplicated;

        $message = "The Fund {$fund->name} has possible duplicated funds registered.";
        $message .= json_encode($duplicated);

        Log::channel('duplication')->warning($message);
    }
}
