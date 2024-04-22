<?php

namespace App\Notifications;

use App\Models\Question;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
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
    public function __construct(Question $question, User $user)
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
        //["mail" , "vonage"]
        $channels = ['database', 'broadcast', 'mail', 'vonage'];
        /*
        if (in_array('mail', $notifiable->notification_options)) {
            $channels[] = 'mail';
        }
        if (in_array('sms', $notifiable->notification_options)) {
            $channels[] = 'vonage';
        }

        */
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
            ->subject(__('New Answer'))
            ->from('notify@stackOverFlow.com')
            ->greeting(__("Hello :name", ['name' => $notifiable->name]))
            ->line(
                __('New Answer From :user On ":question"', [
                    'user' => $this->user->name,
                    'question' => $this->question->title
                ])
            )
            ->action(__('View Answer'), url(route('questions.show', $this->question->id)))
            ->line(__('Thank you for using our application!'));
    }

    /** Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase()
    {
        return [
            'title' => __('New Answer'),
            'body' => __('New Answer From :user On ":question"', [
                'user' => $this->user->name,
                'question' => $this->question->title
            ]),
            'image' => $this->user->photo_url,
            'url' => route('questions.show', $this->question->id)
        ];
    }


    /**
     * Get the Vonage / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\VonageMessage
     */
    public function toVonage($notifiable)
    {
        return (new VonageMessage)
            ->content(__('New Answer From :user On your question', ['user' => $this->user->name]))
            ->from('15554443333')
            ->unicode();
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

    public function toBroadcast($notifiable)
    {
        return [
            'title' => __('New Answer'),
            'body' => __('New Answer From :user On ":question"', [
                'user' => $this->user->name,
                'question' => $this->question->title
            ]),
            'image' => $this->user->getPhotoUrlAttribute(),
            'url' => route('questions.show', $this->question->id)
        ];
    }
}
