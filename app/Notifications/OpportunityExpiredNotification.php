<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class OpportunityExpiredNotification extends Notification implements ShouldQueue
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
        $frontendUrl = env('APP_URL', 'https://admin.conexoesengenharia.com.br');
        $opportunityUrl = $frontendUrl . '/api/opportunity-renew/' . Crypt::encrypt($this->item['id']);

        return (new MailMessage)
            ->subject('Atenção, sua oportunidade foi desativada!')
            ->greeting('Atenção, sua oportunidade foi desativada!')
            ->line('A oportunidade cadastrada na plataforma Conexões Engenharia foi desativada após vencimento do prazo de vigência. ')
            ->line('Caso seja do seu interesse reativar esta oportunidade, acesse o site para reativação.')
            ->action('Renove o prazo do anuncio', $opportunityUrl);
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
