<?php

namespace App\Models;


use Carbon\Carbon;

class Chance extends \Dot\Chances\Models\Chance
{
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
        $diff = (Carbon::parse($this->closing_date)->diffInHours($this->created_at));
        return max(min(((($diff - max($now->diffInHours(Carbon::parse($this->closing_date,false)), 0)) / $diff) * 100), 100),1);
    }


}
