<?php

namespace App\Notifications;

use App\BinhLuan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BinhLuanNotification extends Notification
{
    use Queueable;

    public $binhLuan;

    /**
     * Create a new notification instance.
     *
     * @return void
     * 
     */
    public function __construct(BinhLuan $binhLuan)
    {
        $this->binhLuan = $binhLuan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'nguoi_binh_luan' => $this->binhLuan->user,
            'bai_viet' => $this->binhLuan->baiViet->tieu_de,
            'bai_viet_id' => $this->binhLuan->baiViet->id,
        ];
    }
}
