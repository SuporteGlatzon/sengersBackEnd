<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OpportunityApprovedNotification extends Notification implements ShouldQueue
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
        $days_expire_opportunity = Setting::where('key', 'days_expire_opportunity')->first();

        $days = $days_expire_opportunity ? $days_expire_opportunity->value : 30;

        $frontendUrl = env('NEXT_PUBLIC_BASE_URL', 'https://conexoesengenharia.com.br');
        $opportunityUrl = $frontendUrl . '/oportunidades/' . $this->item['id'];

        return (new MailMessage)
            ->subject('Parabéns, sua oportunidade foi aprovada!')
            ->greeting('Parabéns, sua oportunidade foi aprovada!')
            ->line('A oportunidade que você cadastrou na plataforma Conexões Engenharia foi aprovada e está disponível para acesso pelo prazo de ' . $days . ' dias.')
            ->action('Acesse aqui!', $opportunityUrl);
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
