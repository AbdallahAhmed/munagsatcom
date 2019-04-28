<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
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
    protected $fillable = ['before_points', 'after_points', 'points', 'user_id', 'action', 'object_id', 'company_id'];

    /**
     * Add Type
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getTypeAttribute()
    {
        switch ($this->attributes['action']) {
            case 'tenders.buy':
                return trans('app.types.tenders_buy');
            case 'points.buy':
                return trans('app.types.points_buy');
            case 'add.chance':
                return trans('app.types.add_chance');
            case 'center.add':
                return trans('app.types.add_center');
            case 'center.add.disapproved':
                return trans('app.types.center_add_disapproved');
            case 'center.add.approved':
                return trans('app.types.center_add_approved');
            case 'chances.add.disapproved':
                return trans('app.types.chances_add_disapproved');
            case 'chances.add.approved':
                return trans('app.types.chances_add_approved');
            default:
                return trans('app.not_register');
        }
    }


    /**
     * Path Attribute
     * @return string
     */
    public function getPathAttribute()
    {

        switch ($this->attributes['action']) {
            case 'tenders.buy':
                return $this->tender ? $this->tender->path : 'javascript:void(0)';

            default:
                return 'javascript:void(0)';
        }
    }

    /**
     * Tender Relation with transaction
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class, 'object_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    /**
     *
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->original['created_at'])->setTimezone('GMT+3');
    }

}
