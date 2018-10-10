<?php

namespace Dot\Tenders\Models;

use Cache;
use Dot\Blocks\Models\Block;
use Dot\Categories\Models\Category;
use Dot\Galleries\Models\Gallery;
use Dot\Media\Models\Media;
use Dot\Platform\Model;
use Dot\Posts\Scopes\Post as PostScope;
use Dot\Seo\Models\SEO;
use Dot\Tags\Models\Tag;
use Dot\Users\Models\User;


/**
 * Class Post
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
    protected $table = 'tenders';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $searchable = [
        'title',
        'excerpt',
        'content'

    ];

    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @var array
     */
    protected $sluggable = [
        'slug' => 'title',
    ];

    /**
     * @var array
     */
    protected $creatingRules = [
        'title' => 'required'
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
        'title' => 'required'
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
        return $this->belongsToMany(Category::class, "posts_categories", "post_id", "category_id");
    }
}
