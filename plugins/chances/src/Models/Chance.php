<?php

namespace Dot\Chances\Models;

use DB;
use Dot\Categories\Models\Category;
use Dot\Companies\Models\Company;
use Dot\Media\Models\Media;
use Dot\Platform\Model;
use Dot\Posts\Models\Post;
use Dot\Tags\Models\Tag;
use Dot\Users\Models\User;

/*
 * Class Chance
 * @package Dot\Chances\Models
 */
class Chance extends Model
{

    /*
     * @var bool
     */
    public $timestamps = true;
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


    /**
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
        "number" => "required",
        "closing_date" => "required",
        // "file_name" => "required",
        // "file_description" => "required",
        //"value" => "required"

    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
        "number" => "required",
        "closing_date" => "required",
        // "file_name" => "required",
        // "file_description" => "required",
        //"value" => "required"
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

    public function scopeOpened($query){
        return $query->where('status',0);
    }

    public function scopeClosed($query){
        return $query->where('status',1);
    }

    public function scopeCancelled($query){
        return $query->where('status',2);
    }

    public function scopePending($query){
        return $query->where('status',3);
    }

    public function scopeApproved($query){
        return $query->where('status',4);
    }

    public function scopeRejected($query){
        return $query->where('status',5);
    }

    public function sectors(){
        return $this->belongsToMany(Sector::class, "chances_sectors", "chance_id", "sector_id");
    }

    public function units(){
        return $this->belongsToMany(Unit::class, "chances_units", "chance_id", "unit_id")->withPivot(['quantity', 'name']);
    }

    public function files(){
        return $this->belongsToMany(Media::class, "chances_files", "chance_id", "media_id")->withPivot(['file_name']);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function media(){
        return $this->belongsTo(Media::class);
    }

    public function image(){
        return $this->belongsTo(Media::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function offers(){
        return $this->belongsToMany(Media::class, 'chances_offers_files', 'chance_id', 'media_id');
    }

}
