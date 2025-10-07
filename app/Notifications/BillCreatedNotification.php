<?php

namespace App\Notifications;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BillCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $bill;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $flat = $this->bill->flat;
        $category = $this->bill->billCategory;

        return (new MailMessage)
            ->subject('New Bill Created - ' . $category->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new bill has been created for Flat ' . $flat->flat_number)
            ->line('Building: ' . $flat->building->name)
            ->line('Category: ' . $category->name)
            ->line('Month: ' . date('F Y', strtotime($this->bill->month)))
            ->line('Amount: ৳' . number_format($this->bill->amount, 2))
            ->line('Due Amount: ৳' . number_format($this->bill->due_amount, 2))
            ->line('Status: ' . ucfirst($this->bill->status))
            ->line('Please ensure timely payment.')
            ->line('Thank you!');
    }
}