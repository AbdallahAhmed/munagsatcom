<?php

namespace Dot\Options\Models;

use Dot\Platform\Model;

/*
 * Class Option
 * @package Dot\Options\Models
 */
class Option extends Model
{

    /*
     * @var bool
     */
    public $timestamps = false;
    /*
     * @var bool
     */
    public $incrementing = false;
    /*
     * @var string
     */
    protected $table = "options";

    protected $fillable = ['name', 'value'];

    /*
     * Delete options cache on deleting and saving
     */
    public static function boot()
    {

        parent::boot();

        static::saved(function () {
            //Cache::forget("platform.options");
        });

        static::deleted(function () {
            //Cache::forget("platform.options");

        });
    }

    /*
     * is_localized attribute
     * @return bool
     */
    public function getIsLocalizedAttribute()
    {
        return !in_array($this->lang, [NULL, ""]);
    }


}
