<?php

namespace App\Notifications;

use App\Models\Location\Area;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPost extends Notification
{
  use Queueable;

  private $area_id;
  public function __construct($area_id)
  {
    $this->area_id = $area_id;
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

  public function toDatabase($notifiable)
  {
    $area = Area::find($this->area_id);
    return [
      'message' => 'A new post is added, in ' . $area->name . ' , ' . $area->city->name,
      'post_id' => $notifiable->id,
    ];
  }
}
