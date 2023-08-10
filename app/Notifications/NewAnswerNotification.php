<?php

namespace App\Notifications;

use App\Models\Question;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAnswerNotification extends Notification
{
    use Queueable;

    protected $question;
    protected $user;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Question $question , User $user)
    {
        $this->question = $question;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    // Channels : mail, database, broadcast(real time), nexmo(sms), slack, and custom channels
    public function via($notifiable)
    {
        $channels = ['database'];
//        if (in_array('mail' , $notifiable->notification_options)) {
//            $channels[] = 'mail';
//        }
//        if (in_array('nexmo' , $notifiable->notification_options)) {
//           $channels[] = 'nexmo';
//        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /** Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase()
    {
        return [
            'title'=> __('New Answer'),
            'body'=>__('New Answer From :user On :question'  ,[
                'user'=>$this->user->name,
                'question'=>$this->question->title]),
            'image'=>'https://via.placeholder.com/100',
            'url'=>route('questions.show' , $this->question->id)

        ];
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
            //
        ];
    }
}
