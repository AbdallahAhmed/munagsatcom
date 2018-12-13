<?php

namespace Dot\Pages\Models;

use Dot\Media\Models\Media;
use Dot\Pages\Scopes\Page as PageScope;
use Dot\Platform\Model;
use Dot\Tags\Models\Tag;
use Dot\Users\Models\User;

/*
 * Class Page
 * @package Dot\Pages\Models
 */
class Page extends Model
{

    /*
     * @var bool
     */
    public $timestamps = true;
    /*
     * @var string
     */
    protected $table = 'pages';
    /*
     * @var string
     */
    protected $primaryKey = 'id';
    /*
     * @var array
     */
    protected $searchable = ['title', 'excerpt', 'content'];
    /*
     * @var int
     */
    protected $perPage = 20;

    /*
     * @var array
     */
    protected $sluggable = [
        'slug' => 'title',
    ];

    /*
     * @var array
     */
    protected $creatingRules = [
        'title' => 'required'
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        'title' => 'required'
    ];

    /*
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PageScope);
    }

    /*
     * Image relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne(Media::class, "id", "image_id");
    }

    /*
     * User relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    /*
     * Sync tags
     * @param $tags
     */
    public function syncTags($tags)
    {
        $tag_ids = array();
        if ($tags = @explode(",", $tags)) {
            $tags = array_filter($tags);
            $tag_ids = Tag::saveNames($tags);
        }
        $this->tags()->sync($tag_ids);
    }

    /*
     * Tags relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, "pages_tags", "page_id", "tag_id");
    }

}
