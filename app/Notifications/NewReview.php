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

  private $user_id, $post_id;
  public function __construct($user_id, $post_id = null)
  {
    $this->user_id = $user_id;
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
    $user = User::find($this->user_id);
    return [
      'message' => 'A new review , by ' . $user->name,
      'post_id' => $this->post_id,
    ];
  }
}
