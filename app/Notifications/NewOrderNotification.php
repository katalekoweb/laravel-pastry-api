<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
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
        $message = (new MailMessage)
            ->subject('Email de Novo Pedido.')
            ->line("Olá " . $notifiable?->name . ". Cá estão os detalhes do seu pedido");

        $message->line("+++++++++++++++++++++++++++");
        foreach ($this->order->products as $key => $product) {
            $productItemQtd = OrderProduct::whereOrderId($this->order?->id)->whereProductId($product->id)->first()?->quantity ?? 1;
            
            $message->line("Item: {$product->name} - Qtd.: {$productItemQtd} - Subtotal: R$ {$product->price}");
        }
        $message->line("+++++++++++++++++++++++++++");

        $total = number_format((float)$this->order->products->sum('price'), 2, ".", " ");
        $message->line("Total: R$ $total");
        
        return $message;
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
