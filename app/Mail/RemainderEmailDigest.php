<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemainderEmailDigest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    private $users;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

   
    public function build()
    {
        return $this->markdown('emails.remainder-digest')->with('users',$this->users);
    }
}
