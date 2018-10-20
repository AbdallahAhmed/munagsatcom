<?php

namespace Dot\Services\Models;

use DB;
use Dot\Categories\Models\Category;
use Dot\Platform\Model;
use Dot\Posts\Models\Post;
use Dot\Tags\Models\Tag;

/*
 * Class Block
 * @package Dot\Chances\Models
 */
class Service extends Model
{

    /*
     * @var bool
     */
    public $timestamps = true;
    /*
     * @var string
     */
    protected $table = "services";
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

    public function scopePublished($query){
        return $query->where('status', 1);
    }



}
