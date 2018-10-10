<?php

namespace Dot\Chances\Models;

use DB;
use Dot\Categories\Models\Category;
use Dot\Platform\Model;
use Dot\Posts\Models\Post;
use Dot\Tags\Models\Tag;

/*
 * Class Chance
 * @package Dot\Chances\Models
 */
class Chance extends Model
{

    /*
     * @var bool
     */
    public $timestamps = false;
    /*
     * @var string
     */
    protected $table = "chances";
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
        $v->setCustomMessages((array)trans('chances::validation'));
        $v->setAttributeNames((array)trans("chances::chances.attributes"));
        return $v;
    }



}
