<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NotificationMenu extends Component
{
    public $notifications;
    public $unreadNotificationsCount;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->take(3)->get();

        $this->notifications = $notifications;
        $this->unreadNotificationsCount = $user->unreadNotifications->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notification-menu');
    }
}
