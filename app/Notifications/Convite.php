<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Convite extends Notification
{
    use Queueable;

    private $convite;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($convite)
    {
        $this->convite = $convite;
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
        $url = url('/register');
        $code = $this->convite->codigo;
        $tipo = $this->convite->tipo;
        $tipoStr = "";
        if ($tipo == 'A'){
            $tipoStr = "Administrador";
        }
        if ($tipo == "T"){
            $tipoStr = "Terapeuta";
        }
        return (new MailMessage)
            ->subject('Regul-A - Convite recebido')
            ->greeting('Olá.')
            ->line('Recebeu um convite para se registar em Regul-A')
            ->line('A sua função será de '.$tipoStr)
            ->action('Para concluir o registo aceda aqui', $url)
            ->line('Código de registo: '.$code);
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
