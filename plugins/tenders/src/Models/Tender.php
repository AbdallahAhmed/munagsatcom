<?php

namespace Dot\Tenders\Models;

use Cache;
use Dot\Categories\Models\Category;
use Dot\I18n\Models\Place;
use Dot\Media\Models\Media;
use Dot\Platform\Model;
use Dot\Users\Models\User;


/**
 * Class Tender
 * @package Dot\Posts\Models
 */
class Tender extends Model
{

    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */

    public $module = 'tenders';
    /**
     * @var string
     */
    protected $table = 'tenders';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $searchable = [
        'name',

    ];

    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @var array
     */
    protected $sluggable = [
        'slug' => 'name',
    ];

    /**
     * @var array
     */
    protected $creatingRules = [
        'name' => 'required',
        'cb_downloaded_price' => 'required|numeric|min:0',
        'org_id' => 'required',
        'activity_id' => 'required',
        'cb_id' => 'required|not_in:0',
        'cb_real_price' => 'required|numeric|min:0',
        'number' => 'required'
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
        'name' => 'required',
        'cb_downloaded_price' => 'required|numeric|min:0',
        'org_id' => 'required',
        'activity_id' => 'required',
        'cb_id' => 'required|not_in:0',
        'cb_real_price' => 'required|numeric|min:0',
        'number' => 'required'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Status scope
     * @param $query
     * @param $status
     */
    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case "published":
                $query->where("status", 1);
                break;

            case "unpublished":
                $query->where("status", 0);
                break;
        }
    }

    /**
     * Categories relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, "tenders_categories", "tender_id", "category_id");
    }

    /**
     * places relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function places()
    {
        return $this->belongsToMany(Place::class, "tenders_places", "tender_id", "place_id");
    }

    /**
     * files relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->belongsToMany(Media::class, "tenders_files", "tender_id", "file_id");
    }

    /**
     * User relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

}
