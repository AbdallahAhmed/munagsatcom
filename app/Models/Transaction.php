<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table='transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['before_points', 'after_points', 'points', 'user_id', 'action', 'object_id'];
}
