<?php

namespace Dot\Categories\Models;

use DB;
use Dot\Media\Models\Media;
use Dot\Platform\Model;
use Dot\Users\Models\User;
use Lang;

/*
 * Class Category
 * @package Dot\Categories\Models
 */
class Category extends Model
{

    /*
     * @var string
     */
    protected $module = 'categories';

    /*
     * @var string
     */
    protected $table = 'categories';

    /*
     * @var string
     */
    protected $primaryKey = 'id';

    /*
     * @var string
     */
    protected $parentKey = 'parent';

    /*
     * @var array
     */
    protected $fillable = array('*');

    /*
     * @var array
     */
    protected $guarded = array('id');

    /*
     * @var array
     */
    protected $visible = array();

    /*
     * @var array
     */
    protected $hidden = array();

    /*
     * @var array
     */
    protected $searchable = ['name', 'slug'];

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
        "name" => "required|unique:categories,name",
        "slug" => "unique:categories,slug"
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required|unique:categories,name,[id],id",
        "slug" => "required|unique:categories,slug,[id],id"
    ];

    /*
     * image relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function image()
    {
        return $this->hasOne(Media::class, "id", "image_id");
    }

    /*
     * user relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    /*
     * categories relation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function categories()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    /*
     * @param $query
     * @param int $parent
     */
    function scopeParent($query, $parent = 0)
    {
        $query->where("categories.parent", $parent);
    }
}
