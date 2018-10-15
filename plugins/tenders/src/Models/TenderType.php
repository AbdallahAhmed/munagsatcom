<?php

namespace Dot\Tenders\Models;

use Dot\Platform\Model;
use Dot\Users\Models\User;


/**
 * Class TenderType
 * @package Dot\Tenders\Models
 */
class TenderType extends Model
{

    /**
     * @var string
     */
    protected $table = 'tender_types';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $searchable = [
        'name',
    ];

    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @var array
     */
    protected $sluggable = [
        'slug' => 'name',
    ];

    /**
     * @var array
     */
    protected $creatingRules = [
        'name' => 'required'
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
        'name' => 'required'
    ];

    /**
     * Status scope
     * @param $query
     * @param $status
     */
    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case "published":
                $query->where("status", 1);
                break;

            case "unpublished":
                $query->where("status", 0);
                break;
        }
    }

    /**
     * Published Scope
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Set customer attributes messages
     * @return array
     */
    protected function setValidationAttributes()
    {
        return trans('tenders::types.attributes');
    }

    /**
     * User relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }


}
