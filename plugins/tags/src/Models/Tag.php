<?php

namespace Dot\Tags\Models;

use Dot\Platform\Model;

/*
 * Class Tag
 * @package Dot\Tags\Models
 */
class Tag extends Model
{

    /*
     * @var string
     */
    protected $table = "tags";

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
        "name" => "required|unique:tags,name,[id],id"
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required|unique:tags,name"
    ];

    /*
     * Save multiple tag names
     * @param array $names
     * @return array of tag ids
     */
    public static function saveNames($names = [])
    {

        $tag_ids = [];

        $names = array_unique($names);

        foreach ($names as $name) {
            $tag = self::select("id")->where("name", $name)->first();

            if (count($tag)) {

                // Tag exists

                $tag_ids[] = $tag->id;

            } else {

                // Create new tag

                $tag = new Tag();
                $tag->name = self::cleanTrim($name);

                if ($tag->validate()) {
                    $tag->save();
                    $tag_ids[] = $tag->id;
                }
            }
        }

        return $tag_ids;
    }

    /*
     * @param $v
     * @return mixed
     */
    function setValidation($v)
    {
        $v->setCustomMessages((array)trans('tags::validation'));
        $v->setAttributeNames((array)trans("tags::tags.attributes"));
        return $v;
    }

    /*
     * Count setters
     * @param $value
     */
    function setCountAttribute($value)
    {
        $this->attributes["count"] = 0;
    }


    /**
     * Clean string
     *
     * @param $string
     *
     * @return mixed|string
     */
    public static function cleanTrim($string)
    {
        $string = str_replace("\r\n", '', $string);

        $string = trim($string);

        return $string;
    }
}
