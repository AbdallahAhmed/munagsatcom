<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getUserNotifications(Request $request)
    {

        $limit = $request->get('limit', 15);
        $offset = $request->get('offset', 0);
        $notifications = Notifications::where('user_id',fauth()->user()->id)
            ->limit($limit)
            ->offset($offset)
            ->orderBy('updated_at','DESC')
            ->paginate(10);
        foreach ($notifications as $notification){
            $notification->isRead = 1;
            $notification->save();
        }
        if ($request->ajax()) {
            return response()->json(['notifications' => $notifications, 'count' => count($notifications)]);
        }

        return view('users.notifications', ['notifications'=>$notifications]);
    }

    public function getUnreadNotifications(Request $request)
    {

        $notification = Notifications::where([
            ['user_id', fauth()->user()->id],
            ['isRead', 0],
            ['created_at', '>', \Carbon\Carbon::now()->subSeconds(40)->toDateTimeString()]
        ])->first();
        if ($request->ajax()) {
            return response()->json(['notifications' => $notification]);
        }
    }
}
