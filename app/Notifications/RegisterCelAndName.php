<?php

namespace App\Notifications;

use App\Entities\ProductWanted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterCelAndName extends Notification
{
    use Queueable;

    /**
     * @var ProductWanted
     */
    private $productWanted;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductWanted $productWanted)
    {
        //
        $this->productWanted = $productWanted;
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

        return (new MailMessage)
                    ->subject('Notificação de Cadastro no SITE')
                    ->greeting('Novo Cliente:')
                    ->line($this->productWanted->user->name)
                    ->line($this->productWanted->user->userable->contacts->first()->cel)
                    ->line($this->productWanted->product->name)
                    ->line('Boa Venda!!!');

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
