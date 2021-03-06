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
        $diff = max(($this->last_get_offer_at->diffInDays($this->published_at)), 1);
        return max(min(((($diff - max($now->diffInDays($this->last_get_offer_at, false), 0)) / $diff) * 100), 100), 1);
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
        if (isset($this->original['IsBought_cache'])) {
            return $this->original['IsBought_cache'];
        }
        return $this->original['IsBought_cache'] = ($this->buyers()->where('user_id', fauth()->id())->count() > 0) ||
            (fauth()->user()->in_company && Transaction::where(['object_id' => $this->id, 'action' => 'tenders.buy', 'company_id' => fauth()->user()->company[0]->id])->count() > 0);
    }


    /**
     *  get all transactions for tenders
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'object_id')->where('action', 'tenders.buy');
    }

//    /**
//     *
//     */
//    public function getCreatedAtAttribute()
//    {
//        return Carbon::parse($this->original['created_at'])->setTimezone('GMT+3');
//    }
//
//    /**
//     * @return Carbon
//     */
//    public function getPublishedAtAttribute()
//    {
//        return Carbon::parse($this->original['published_at'])->setTimezone('GMT+3');
//    }
//    /**
//     * @return Carbon
//     */
//    public function getLastGetOfferAtAttribute()
//    {
//        return Carbon::parse($this->original['last_get_offer_at'])->setTimezone('GMT+3');
//    }
//
//
//    /**
//     * @return Carbon
//     */
//    public function getFilesOpenedAtAttribute()
//    {
//        return Carbon::parse($this->original['files_opened_at'])->setTimezone('GMT+3');
//    }


}
