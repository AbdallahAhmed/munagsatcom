<?php

namespace App\Models;

use Dot\Tenders\Models\Tender as Model;
use Dot\Tenders\Models\TenderOrg;

class Tender extends Model
{


    protected $dates=[
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
     *  add path attribute
     */
    public function getPathAttribute()
    {
        return 'tender.path.test';
    }
}
