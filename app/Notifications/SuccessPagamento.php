<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\OrderData;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuccessPagamento extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    private $user;
    private OrderData $orderData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user,OrderData $orderData)
    {

        //
        $this->user = $user;
        $this->orderData = $orderData;
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
            ->subject('Notificação de Pagamento')
            ->greeting('Cliente:')
            ->line($this->user->name)
            ->line('Contato: ' . $this->user->cel)
            ->line('Data da compra: ' . data_reverse_traco($this->orderData->order->data))
            ->line('Valor total da compra: R$' . number_format($this->orderData->order->total,2,',','.'));

           // ->line('Boa Venda!!!');
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
