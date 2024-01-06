<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DuplicatedFundWarning
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $fund = null;
    public $duplicated = null;
    /**
     * Create a new event instance.
     */
    public function __construct($fund, $duplicated)
    {
        $this->fund = $fund;
        $this->duplicated = $duplicated;
    }
}
