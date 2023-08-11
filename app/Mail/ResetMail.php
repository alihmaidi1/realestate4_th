<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetMail extends Mailable
{
  use Queueable, SerializesModels;

  protected $reset_code;
  protected $SignedUrl;
  /**
   * Create a new message instance.
   */
  public function __construct($reset_code, $SignedUrl = "")
  {
    $this->reset_code = $reset_code;
    $this->SignedUrl = $SignedUrl;
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Reset Mail',
    );
  }

  public function build()
  {
    return $this->view('api.admin.password.reset', ["reset_code" => $this->reset_code, "SignedUrl" => $this->SignedUrl]);
  }
}
