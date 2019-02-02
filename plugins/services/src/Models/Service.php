<?php

namespace Dot\Services\Models;

use Dot\Platform\Model;

/*
 * Class Service
 * @package Dot\Services\Models
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
        'price_from'=>'required',
        'price_to'=>'required',
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
        'price_from'=>'required',
        'price_to'=>'required',
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
