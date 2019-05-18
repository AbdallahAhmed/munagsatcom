<?php

namespace App\Models;

use App\User;
use function GuzzleHttp\Psr7\str;
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
                $data['message'] = trans('notifications.'.$this->key);
                $data['tender_id'] = $extra->tender_id;
                return $data;
            case 'to.company.tender.bought':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':user',User::find($extra->buyer_id)->name,trans('notifications.'.$this->key));
                $data['buyer.id'] = $extra->buyer_id;
                $data['tender_id'] = $extra->tender_id;
                return $data;
            case 'chance.pay':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':chance',Chance::find($extra->chance_id)->name,trans('notifications.'.$this->key));
                $data['chance_id'] = $extra->chance_id;
                return $data;
            case 'chance.refund':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':chance',Chance::find($extra->chance_id)->name,trans('notifications.'.$this->key));
                $data['chance_id'] = $extra->chance_id;
                return $data;
            case 'center.pay':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':center',Center::find($extra->center_id)->name,trans('notifications.'.$this->key));
                $data['center_id'] = $extra->center_id;
                return $data;
            case 'center.refund':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':center',Center::find($extra->center_id)->name,trans('notifications.'.$this->key));
                $data['center_id'] = $extra->center_id;
                return $data;
            case 'center.contact':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':center',$extra->center,trans('notifications.'.$this->key));
                $data['message'] = str_replace(':email',$extra->email, $data['message']);
                $data['message'] = str_replace(':name',$extra->name,$data['message']);
                $data['message'] = str_replace(':message', $extra->message, $data['message']);
                return $data;
            case 'chance.approval':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':chance',Chance::find($extra->chance_id)->name,trans('notifications.'.$this->key));
                $data['chance_id'] = $extra->chance_id;
                return $data;
            case 'chance.self.approval':
                $extra = json_decode($this->data);
                $data['message'] = str_replace(':chance',Chance::find($extra->chance_id)->name,trans('notifications.'.$this->key));
                $data['message'] = str_replace(':user',User::find($extra->user_id)->name,$data['message']);
                $data['chance_id'] = $extra->chance_id;
                return $data;
            default:
                $data['message'] = str_replace(':email', fauth()->user()->email, trans('notifications.'.$this->key));
                return $data;
        }
    }
}
