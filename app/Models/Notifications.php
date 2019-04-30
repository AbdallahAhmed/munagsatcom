<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $dates=['created_at','updated_at'];
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getBodyAttribute(){
        $data = array();
        switch ($this->key){
            case 'tender.bought':
                $extra = json_decode($this->data);
                $data['message'] = trans('notifications.tender.bought');
                $data['tender_id'] = $extra->tender_id;
                return $data;
            case 'to.company.tender.bought':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':user',User::find($extra->buyer_id)->name,trans('notifications.to.company.tender.bought'));
                $data['buyer.id'] = $extra->buyer_id;
                $data['tender_id'] = $extra->tender_id;
                return $data;
            case 'chance.pay':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':chance',Chance::find($extra->chance_id)->name,trans('notifications.chance.pay'));
                $data['chance_id'] = $extra->chance_id;
                return $data;
            case 'chance.refund':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':chance',Chance::find($extra->chance_id)->name,trans('notifications.chance.refund'));
                $data['chance_id'] = $extra->chance_id;
                return $data;
            case 'center.pay':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':center',Center::find($extra->center_id)->name,trans('notifications.center.pay'));
                $data['center_id'] = $extra->center_id;
                return $data;
            case 'center.refund':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':center',Center::find($extra->center_id)->name,trans('notifications.center.refund'));
                $data['center_id'] = $extra->center_id;
                return $data;
            default:
                $data['message'] = trans('notifications.'.$this->key);
                return $data;
        }
    }
}
