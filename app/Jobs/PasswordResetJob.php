<?php

namespace App\Jobs;

use App\Events\PasswordResetEvent;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public $user;
    public $extra_obj;

    public function __construct( $user, $extra_obj)
    {
        


        $this->user = $user;
        $this->extra_obj = $extra_obj;
        
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        PasswordResetEvent::dispatch($this->user, $this->extra_obj);
    }
}
