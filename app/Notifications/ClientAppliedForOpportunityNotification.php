<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientAppliedForOpportunityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $item;
    private $candidate;

    /**
     * Create a new notification instance.
     */
    public function __construct($item, $candidate)
    {
        $this->item = $item;
        $this->candidate = $candidate;
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
        $opportunityUrl = $frontendUrl . '/minhas-oportunidades/' . $this->item['id'];

        return (new MailMessage)
            ->subject('Seu anúncio recebeu uma proposta.')
            ->greeting('Seu anúncio recebeu uma proposta.')
            ->line('O anuncio de oportunidade que você cadastrou na plataforma Conexões Engenharia recebeu uma proposta. Acesse e avalie.')
            ->action('Ver proposta', $opportunityUrl);
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
