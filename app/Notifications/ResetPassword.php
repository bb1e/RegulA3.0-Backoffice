<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ResetPassword extends Notification
{
    use Queueable;

    private $codigo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/reset/newpassword');
        $code = $this->codigo;
        return (new MailMessage)
            	    ->subject('Regul-A - Pedido de mudança de Password')
                    ->greeting('Olá.')
                    ->line('Recebemos um pedido para mudar de password.')
                    ->line(new HtmlString('O seu código de confirmação: <strong>' . $code . '</strong>'))
                    ->action('Para mudar de password aceda aqui', $url)
                    ->line('Este código será válido durante 24 horas');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
