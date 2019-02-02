<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Collection;

class Company extends \Dot\Companies\Models\Company
{
    /**
     * Changes relations
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chances()
    {
        return $this->hasMany(Chance::class, 'company_id', 'id');
    }

    /**
     *  Add chances property
     * @return Collection
     */
    public function getEmailAttribute()
    {
        return $this->user->email;

    }

    /**
     *  Add path property
     * @return string
     */
    public function getPathAttribute()
    {
        return route('company.show', ['slug' => $this->slug]);
    }
}
