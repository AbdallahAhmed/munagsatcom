<?php

namespace App\Models;


use Carbon\Carbon;

class Chance extends \Dot\Chances\Models\Chance
{

    /**
     * Auto cast dates
     * @var array
     */
    protected $dates = ['closing_date', 'created_at', 'updated_at'];

    /**
     *  Add path property
     * @return string
     */
    public function getPathAttribute()
    {
        return route('chances.show', ['slug' => $this->slug]);
    }

    /**
     *  add path attribute
     */
    public function getProgressAttribute()
    {
        $now = Carbon::now();
        $diff = max($this->closing_date->diffInDays($this->created_at), 1);
        return max(min(((($diff - max($now->diffInDays($this->closing_date, false), 0)) / $diff) * 100), 100), 1);
    }

    /**
     * @return Carbon
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->original['created_at'])->setTimezone('GMT+3');
    }

    /**
     * @return Carbon
     */
    public function getClosingDateAttribute()
    {
        return Carbon::parse($this->original['closing_date'])->setTimezone('GMT+3');
    }


    /**
     *
     */
    public function can_edit()
    {
        if(!fauth()->user())
            return false;
        if ($this->user_id == fauth()->id()) {
            return true;
        }
        $user = fauth()->user();
        if ($user->in_company) {
            return $user->company[0]->id == $this->company_id;
        }
        return false;
    }

}
