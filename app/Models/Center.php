<?php

namespace App\Models;


class Center extends \Dot\Services\Models\Center
{
    /**
     *  Add path property
     * @return string
     */
    public function getPathAttribute(){
        return route('centers.show', ['center_id' => $this->id]);
    }
}
