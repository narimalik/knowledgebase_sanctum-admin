<?php

namespace App\Listeners;

use App\Mail\RestPasswrodMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PasswordResetListener
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

   

         $mail = new RestPasswrodMail($event->user, $event->extra_obj);
         
         Mail::to($event->user)->send($mail);
        
    }
}
