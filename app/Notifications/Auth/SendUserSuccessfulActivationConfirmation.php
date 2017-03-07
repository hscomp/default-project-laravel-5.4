<?php

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendUserSuccessfulActivationConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    private $loginLink;

    /**
     * Create a new notification instance.
     *
     * @param $loginLink
     */
    public function __construct($loginLink)
    {
        $this->loginLink = $loginLink;
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
            ->subject('Aktivace účtu')
            ->greeting('Účet aktivován!')
            ->line('Tvůj účet na webu ' . config('app.name') . ' byl úspěšně aktivován.')
            ->line('Nyní se můžeš přihlásit.')
            ->action('Přihlásit se', $this->loginLink);
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
