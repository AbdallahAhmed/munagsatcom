<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'notifications';

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
            case 'user.register':
                $data['message'] = trans('notifications.user.register');
                return $data;
            case 'password.reset':
                $data['message'] = trans('notifications.password.reset');
                return $data;
            case 'password.change':
                $data['message'] = trans('notifications.password.change');
                return $data;
            case 'chance.add':
                $data['message'] = trans('notifications.chance.add');
                return $data;
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
        }
    }
}
