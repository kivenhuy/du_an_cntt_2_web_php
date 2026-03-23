<?php

namespace App\Notifications;

use App\Models\RequestForProduct;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Request;

class WelcomeNotification extends Notification
{
    use Queueable;
    private $details;
    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $seller_name = "";
        $buyer_name = User::find($this->details['buyer_id'])->name;
        if($this->details['shop_id'] != 0)
        {
            $seller_name = Shop::find($this->details['shop_id'])->user->name;
        }
        
        return [
            'request_id'      => $this->details['id'],
            'request_code'    => $this->details['code'],
            'user_id'       => $buyer_name,
            'seller_id'     => $seller_name,
            'status'        => $this->details['status'],
        ];
    }
}
