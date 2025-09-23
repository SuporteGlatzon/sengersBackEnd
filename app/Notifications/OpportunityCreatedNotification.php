<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OpportunityCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $item;

    /**
     * Create a new notification instance.
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $backendUrl = env('APP_URL', 'https://admin.conexoesengenharia.com.br');
        $opportunityUrl = $backendUrl . '/opportunities/' . $this->item['id'];

        return (new MailMessage)
            ->subject('Uma nova oportunidade foi cadastrada.')
            ->greeting('Uma nova oportunidade foi cadastrada.')
            ->line('Uma nova oportunidade na plataforma Conexões Engenharia foi cadastrada e aguarda a sua análise.')
            ->action('Avaliar oportunidade', $opportunityUrl);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
