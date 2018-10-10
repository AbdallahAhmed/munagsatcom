<?php

namespace Dot\Blocks\Models;

use DB;
use Dot\Categories\Models\Category;
use Dot\Platform\Model;
use Dot\Posts\Models\Post;
use Dot\Tags\Models\Tag;

/*
 * Class Block
 * @package Dot\Blocks\Models
 */
class Block extends Model
{

    /*
     * @var bool
     */
    public $timestamps = false;
    /*
     * @var string
     */
    protected $table = "blocks";
    /*
     * @var string
     */
    protected $primaryKey = 'id';
    /*
     * @var array
     */
    protected $searchable = ['name'];
    /*
     * @var int
     */
    protected $perPage = 20;
    /*
     * @var array
     */
    protected $sluggable = [
        'slug' => 'name',
    ];

    /*
     * @var array
     */
    protected $creatingRules = [
        "name" => "required",
        "limit" => "required|numeric"
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
        "limit" => "required|numeric"
    ];

    /*
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    /*
     * @param $v
     * @return mixed
     */
    function setValidation($v)
    {
        $v->setCustomMessages((array)trans('blocks::validation'));
        $v->setAttributeNames((array)trans("blocks::blocks.attributes"));
        return $v;
    }

    /*
     * @param $value
     */
    function setCountAttribute($value)
    {
        $this->attributes["count"] = 0;
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
        return $this->belongsToMany(Tag::class, "blocks_tags", "block_id", "tag_id");
    }

    /*
     * categories relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, "blocks_categories", "block_id", "category_id");
    }

    /*
     * Add post to block
     * @param $post
     * @return bool
     */
    public function addPost($post)
    {

        if (!is_object($post) || count($post) == 0) {
            return false;
        }

        $posts_ids = $this->posts->pluck("id");

        if (!in_array($post->id, $posts_ids->toArray())) {

            $posts_ids->prepend($post->id)->splice($this->limit);

            $sync = [];
            $i = 0;

            foreach ($posts_ids as $post_id) {
                $sync[$post_id] = [
                    'lang' => app()->getLocale(),
                    'order' => $i,
                ];
                $i++;
            }

            DB::table("posts_blocks")->where("block_id", $this->id)->where("lang", app()->getLocale())->delete();
            $this->posts()->attach($sync);
        }

    }

    /*
     * Posts relation
     * @return mixed
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, "posts_blocks", "block_id", "post_id")->orderBy('order')->withPivot('order');
    }

    /*
     * Remove post from block
     * @param $post
     * @return bool
     */
    public function removePost($post)
    {

        if (!is_object($post) || count($post) == 0) {
            return false;
        }

        $this->posts()->detach($post->id);

    }

}
