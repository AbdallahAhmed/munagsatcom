<?php

namespace Dot\Services\Models;

use DB;
use Dot\Chances\Models\Sector;
use Dot\Platform\Model;

/*
 * Class Center
 * @package Dot\Services\Models
 */
class Center extends Model
{

    /*
     * @var bool
     */
    public $timestamps = true;
    /*
     * @var string
     */
    protected $table = "centers";
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
        "email_address" => "required|email",
        "sector_id" => 'required',
        "address" => 'required',

    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
        "email_address" => "required|email",
        "sector_id" => 'required',
        "address" => 'required',

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
        $v->setCustomMessages((array)trans('services::validation'));
        $v->setAttributeNames((array)trans("services::centers.attributes"));
        return $v;
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class, 'centers_services','center_id','service_id');
    }

    public function scopePublished($query){
        return $query->where('status', 1);
    }


}
