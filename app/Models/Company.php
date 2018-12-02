<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Collection;

class Company extends \Dot\Companies\Models\Company
{
    /**
     *  Add chances property
     * @return Collection
     */
    public function getChancesAttribute()
    {
        return Chance::where('company_id', $this->id)->get();

    }
}
