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

    public function fetchNotification($id){
        $notification = Notifications::where($id)->firstOrFail();
        $data = array();
        switch ($notification->key){
            case 'user.register':
                $data['message'] = trans('notifications.user.register');
                return $data;
            case 'password.reset':
                $data['message'] = trans('notifications.password.reset');
                return $data;
            case 'tender.bought':
                $extra = json_decode($notification->data);
                $data['message'] = trans('notifications.tender.bought');
                $data['buyer.id'] = $extra->user_id;
                $data['tender_id'] = $extra->tender_id;
                return $data;
            case 'to.company.tender.bought':
                $extra = json_decode($notification->data);
                $data['message'] = preg_replace(':user',User::find($extra->buyer_id)->name,trans('to.company.tender.bought'));
                $data['buyer.id'] = $extra->buyer_id;
                $data['tender_id'] = $extra->tender_id;
                return $data;
        }
    }
}
