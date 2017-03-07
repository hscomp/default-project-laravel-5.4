<?php

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendUserRegistrationActivationLink extends Notification implements ShouldQueue
{
    use Queueable;

    private $activationLink;

    /**
     * Create a new notification instance.
     *
     * @param $activationLink
     */
    public function __construct($activationLink)
    {
        $this->activationLink = $activationLink;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param User $user
     * @return array
     */
    public function via(User $user)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param User $user
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $user)
    {
        return (new MailMessage)
            ->subject('Žádost o registraci účtu')
            ->greeting('Aktivuj svůj účet!')
            ->line('Byla obdržena žádost o registraci na webu ' . config('app.name') . '.')
            ->line('Jméno: ' . $user->present()->fullName())
            ->line('Před prvním přihlášením je nutné aktivovat tvůj účet.')
            ->action('Aktivovat účet', $this->activationLink)
            ->line('Díky, že ses rozhodl pro registraci na webu!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
