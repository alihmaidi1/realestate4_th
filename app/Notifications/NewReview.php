<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewReview extends Notification
{
  use Queueable;

  private $post_id;
  public function __construct($post_id = null)
  {
    $this->post_id = $post_id;
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
    $name = explode("&&", aauth()->name);
    $name = implode(' ', $name);
    return [
      'message' => 'A new review , by ' . $name,
      'post_id' => $this->post_id,
    ];
  }
}
