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
}
