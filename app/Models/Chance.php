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
        $diff = max($this->closing_date->diffInHours($this->created_at),1);
        return max(min(((($diff - max($now->diffInHours($this->closing_date, false), 0)) / $diff) * 100), 100), 1);
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

}
