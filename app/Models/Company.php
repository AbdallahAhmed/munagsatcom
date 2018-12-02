<?php

namespace App\Models;


class Company extends \Dot\Companies\Models\Company
{
    public function getChancesAttribute()
    {
        return Chance::where('company_id', $this->id)->get();

    }
}
