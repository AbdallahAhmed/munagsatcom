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
    protected $table = 'transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['before_points', 'after_points', 'points', 'user_id', 'action', 'object_id'];

    /**
     * Add Type
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getTypeAttribute()
    {
        switch ($this->attributes['action']) {
            case 'tenders.buy':
                return trans('app.types.tenders_buy');

            default:
                return trans('app.types.not_register');
        }
    }
}
