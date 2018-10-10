<?php

namespace Dot\Chances\Models;

use DB;
use Dot\Categories\Models\Category;
use Dot\Platform\Model;
use Dot\Posts\Models\Post;
use Dot\Tags\Models\Tag;

/*
 * Class Unit
 * @package Dot\Chances\Models
 */
class Sector extends Model
{

    /*
     * @var bool
     */
    public $timestamps = false;
    /*
     * @var string
     */
    protected $table = "sectors";
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
    protected $creatingRules = [
        "name" => "required",
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
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
        $v->setAttributeNames((array)trans("chances::sectors.attributes"));
        return $v;
    }

    public function chances(){
        return $this->belongsToMany(Chance::class, "chances_sectors", "sector_id", "chance_id");
    }


}
