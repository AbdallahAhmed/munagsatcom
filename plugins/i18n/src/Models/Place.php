<?php

namespace Dot\I18n\Models;

use Dot\Media\Models\Media;

use Dot\Platform\Model;

/*
 * Class Place
 * @package Dot\Places\Models
 */

class Place extends Model
{

    /*
     * @var string
     */
    protected $table = "places";

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
     * @var bool
     */
    public $timestamps = false;

    /*
     * lang fields
     */
    protected $translatable = [
        'name',
        'currency'
    ];

    /*
     * Casts
     * @var array
     */
    protected $casts = [
        'name' => 'json',
        'currency' => 'json'
    ];

    /*
     * Image relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne(Media::class, "id", "image_id");
    }

    /*
     * Code setter
     */
    public function setCodeAttribute($code){
        $this->attributes["code"] = strtolower($code);
    }

    /*
     * Code getter
     */
    public function getCodeAttribute($code){
        return strtoupper($code);
    }

}
