<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppliedForOpportunitySuccessfulNotification extends Notification implements ShouldQueue
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
        $frontendUrl = env('NEXT_PUBLIC_BASE_URL', 'https://conexoesengenharia.com.br');
        $opportunityUrl = $frontendUrl . '/oportunidades/' . $this->item['id'];

        return (new MailMessage)
            ->subject('Sua candidatura foi registrada!')
            ->greeting('Sua candidatura foi registrada!')
            ->line('Confirmamos o registro da candidatura realizada na plataforma Conexões Engenharia.')
            ->action('Ver minhas conexões', $opportunityUrl);
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
