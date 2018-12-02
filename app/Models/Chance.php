<?php

namespace App\Models;


class Chance extends \Dot\Chances\Models\Chance
{
    /**
     *  Add path property
     * @return string
     */
    public function getPathAttribute()
    {
        return route('chances.show', ['id' => $this->id]);
    }

}
