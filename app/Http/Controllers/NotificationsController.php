<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('notifications.index', [
            'notifications' => $user->notifications
        ]);
    }

    // delete notification
    public function destroy($notification_id)
    {

        if ($notification_id && Auth::check()) {
            $user = Auth::user();
            $notification = $user->notifications()->find($notification_id);

            if ($notification) {
                $notification->delete();
            }
        }

        // toastr notification
        toastr()->success('Notification deleted successfully');
        return redirect()->back();
    }
}
