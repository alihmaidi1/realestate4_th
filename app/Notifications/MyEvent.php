<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Services\ApiResponseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MyEvent extends Notification
{
  use Queueable;

  public $comment;
  public function __construct(Comment $comment)
  {
    $this->comment = $comment;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['broadcast'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toBroadcast($notifiable)
  {
    return new BroadcastMessage([
      'ApiResponseService::successResponse($this->comment)'=>$this->comment
    ]);
  }
}
