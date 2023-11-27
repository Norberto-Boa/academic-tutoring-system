<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentRequestToAdmin extends Notification
{
  use Queueable;

  public $user;
  public $_requestId;
  public $lecturer;

  /**
   * Create a new notification instance.
   */
  public function __construct($user, $_requestId, $lecturer)
  {
    $this->user = $user;
    $this->_requestId = $_requestId;
    $this->lecturer = $lecturer;
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
    return (new MailMessage)
      ->greeting('Greetings administrator!')
      ->line('We kindly want to warn you that the student ' . $this->user->name . ' has made a project Proposal!')
      ->line('Click the following button to access more information about the proposal!')
      ->action('Check the proposal', url(route('request.showByRequestId', ["id" => $this->_requestId])))
      ->line('Frelimo Hoye!')
      ->cc($this->lecturer);
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
