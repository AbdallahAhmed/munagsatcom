<?php

namespace App\Models;


use Carbon\Carbon;

class Chance extends \Dot\Chances\Models\Chance
{
    /**
     *  Add path property
     * @return string
     */
    public function getPathAttribute(){
        return route('chances.show', ['slug' => $this->slug]);
    }

    /**
     *  add path attribute
     */
    public function getProgressAttribute()
    {
        $now = Carbon::now();
        return max(abs(($this->created_at->diffInHours($now) / Carbon::parse($this->closing_date)->diffInHours($now)) * 100), 1);
    }

}
