<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $notification_id = $request->query('notify_id');

        if ($notification_id && Auth::check()) {
            $user = Auth::user();
            $notification = $user->unreadnotifications()->find($notification_id);

            if ($notification && $notification->unread()) {
                    $notification->markAsRead();}
            }

        return $next($request);
    }
}
