<?php

namespace App\Models;


use Dot\Services\Models\Service;

class Center extends \Dot\Services\Models\Center
{
    /**
     *  Add path property
     * @return string
     */
    public function getPathAttribute(){
        return route('centers.show', ['slug' => $this->slug]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services(){
        return $this->belongsToMany(Service::class, 'centers_services','center_id','service_id')->where('status',1);
    }

}
