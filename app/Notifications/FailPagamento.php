<?php

namespace App\Notifications;


use App\Models\OrderData;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FailPagamento extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    private $user;

    /**
     * @var OrderData
     */
    private $order_data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user,OrderData $order_data)
    {
        //
        $this->user = $user;
        $this->order_data = $order_data;
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
            ->subject('Erro de Pagamento')
            ->greeting('Cliente:')
            ->line($this->user->name)
            ->line($this->user->cel)
            ->line('Erro Nº: ' . $this->order_data->cod_retorno)
            ->line('Mensagem: ' . $this->order_data->message)
            ->line('Data da compra: ' . data_reverse_traco($this->order_data->order->data))
            ->line('Valor da tentativa da compra: R$' . number_format($this->order_data->order->total,2,',','.'));

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
