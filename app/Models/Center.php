<?php

namespace App\Models;


use App\User;
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

    /**
     * @return bool
     */
    public function getCanEditAttribute(){
        return fauth()->user() && ($this->user_id == fauth()->id() || Companies_empolyees::where(['company_id' => $this->company_id, 'employee_id' => fauth()->id(), 'accepted' => 1, 'status' => 1])->count() > 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(){
        return $this->hasOne(User::class, "id", "user_id");
    }

}
