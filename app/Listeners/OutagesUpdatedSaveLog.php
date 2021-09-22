<?php

namespace App\Listeners;

use App\Events\OutagesUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OutagesUpdatedSaveLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OutagesUpdated  $event
     * @return void
     */
    public function handle(OutagesUpdated $event)
    {
        //
    }
}
