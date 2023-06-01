<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class FailedLogin
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->unsuccessful_login_count += 1 ;
        $unsuccessful_count =   5;

        if ($event->user->unsuccessful_login_count > $unsuccessful_count) {
            $event->user->status = 0;
            $event->user->unsuccessful_login_count = 0;
        }

        $event->user->save();
        if ($event->user->status == 0) {
            Session::flash('alert', 'danger|Your have been blocked! Contact Administrator ');
        } else {
            Session::flash('alert', 'danger|Failed Attempts: '.$event->user->unsuccessful_login_count.'. Remaining: '. ($unsuccessful_count- $event->user->unsuccessful_login_count).'You will be blocked');
        }
    }
}
