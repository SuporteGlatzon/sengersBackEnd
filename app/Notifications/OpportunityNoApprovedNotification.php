<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OpportunityNoApprovedNotification extends Notification implements ShouldQueue
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
        $opportunityUrl = $frontendUrl . '/minhas-oportunidades/' . $this->item['id'];

        return (new MailMessage)
            ->subject('Atenção, sua oportunidade foi negada!')
            ->greeting('Atenção, sua oportunidade foi negada!')
            ->line($this->item['situation_description'])
            ->line('A oportunidade cadastrada na plataforma Conexões Engenharia não atendeu à política de anuncio.')
            ->line('Caso seja do seu interesse em revisar a oportunidade, clique no botão abaixo.')
            ->action('Ajuste a proposta de oportunidade', $opportunityUrl);
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
