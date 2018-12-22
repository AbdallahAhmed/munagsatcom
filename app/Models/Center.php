<?php

namespace App\Models;


class Center extends \Dot\Services\Models\Center
{
    /**
     *  Add path property
     * @return string
     */
    public function getPathAttribute(){
        return route('centers.show', ['slug' => $this->slug]);
    }
}
