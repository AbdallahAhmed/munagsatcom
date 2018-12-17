<?php

namespace App\Models;

use Dot\Tenders\Models\Tender as Model;
use Dot\Tenders\Models\TenderActivity;
use Dot\Tenders\Models\TenderOrg;
use Dot\Tenders\Models\TenderType;

class Tender extends Model
{


    protected $dates = [
        'published_at',
        'last_queries_at',
        'last_get_offer_at',
        'files_opened_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @param $query
     * @return $query
     */
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    /**
     * org relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function org()
    {
        return $this->hasOne(TenderOrg::class, "id", "org_id");
    }


    /**
     * activity relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activity()
    {
        return $this->hasOne(TenderActivity::class, "id", "activity_id");
    }

    /**
     * type relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(TenderType::class, "id", "type_id");
    }

    /**
     *  add path attribute
     */
    public function getPathAttribute()
    {
        return route('tenders.details', ['slug' => $this->slug]);
    }

    /**
     *  add path attribute
     */
    public function getProgressAttribute()
    {
        return abs($this->published_at->diffInHours()/$this->files_opened_at->diffInHours()*100);
    }

}
