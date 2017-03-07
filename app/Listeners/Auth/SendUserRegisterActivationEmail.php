<?php

namespace App\Listeners\Auth;

use App\Events\UserRegistered;
use App\Notifications\Auth\SendUserRegistrationActivationLink;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserRegisterActivationEmail
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if (config('registration.email_activation.user')) {
            $event->user->notify(new SendUserRegistrationActivationLink());
        }
    }
}
