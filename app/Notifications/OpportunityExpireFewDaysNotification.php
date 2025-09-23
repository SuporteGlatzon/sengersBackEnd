<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class OpportunityExpireFewDaysNotification extends Notification implements ShouldQueue
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
        $days = Carbon::parse($this->item['expire_at'])->diff(now())->days;

        $frontendUrl = env('APP_URL', 'https://admin.conexoesengenharia.com.br');
        $opportunityUrl = $frontendUrl . '/api/opportunity-renew/' . Crypt::encrypt($this->item['id']);

        return (new MailMessage)
            ->subject('Atenção! Seu anuncio expira em cinco (' . $days . ') dias!')
            ->greeting('Atenção! Seu anuncio expira em cinco (' . $days . ') dias!')
            ->line(' A oportunidade que você anunciou na plataforma Conexões Engenharia, expira em cinco (' . $days . ') dias')
            ->line('Caso seja do seu interesse manter o anuncio, revalide a proposta.')
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
