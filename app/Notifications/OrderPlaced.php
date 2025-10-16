<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderPlaced extends Notification
{
    use Queueable;

    protected $order;
    public function __construct(Order $order) { $this->order = $order; }

    public function via($notifiable) { return ['mail']; }

    public function toMail($notifiable) {
        return (new MailMessage)
                    ->subject('Order Confirmation')
                    ->line("Your order #{$this->order->id} has been placed.")
                    ->action('View Order', url('/orders/'.$this->order->id))
                    ->line('Thank you for shopping with us!');
    }
}
