<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dot\Media\Models\Media;
use Dot\Tenders\Models\Tender as Model;
use Dot\Tenders\Models\TenderActivity;
use Dot\Tenders\Models\TenderOrg;
use Dot\Tenders\Models\TenderType;

class Tender extends Model
{


    /**
     * Parse this dates
     * @var array
     */
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
     * cb relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cb()
    {
        return $this->hasOne(Media::class, "id", "cb_id");
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
     * Buyers relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function buyers()
    {
        return $this->belongsToMany(User::class, "tender_buyers", "tender_id", "user_id");
    }

    /**
     *  add path attribute
     */
    public function getPathAttribute()
    {
        return route('tenders.details', ['lang' => app()->getLocale() ? app()->getLocale() : 'ar', 'slug' => $this->slug]);
    }

    /**
     *  add path attribute
     */
    public function getProgressAttribute()
    {
        $now = Carbon::now();
        $diff = max(($this->files_opened_at->diffInHours($this->published_at)), 1);
        return max(min(((($diff - max($now->diffInHours($this->files_opened_at, false), 0)) / $diff) * 100), 100), 1);
    }


    /**
     * add points attribute
     * @return float|
     */
    public function getPointsAttribute()
    {
        return $this->cb_downloaded_price * intval(option('point_per_reyal', 1));
    }

    /**
     * Is login user buy it cb
     * @return bool|mixed
     */
    public function getIsBoughtAttribute()
    {
        if ($this->IsBought_cache) {
            return $this->IsBought_cache;
        }
        return $this->IsBought_cache = $this->buyers()->where('user_id', fauth()->id())->count() > 0;
    }

}
