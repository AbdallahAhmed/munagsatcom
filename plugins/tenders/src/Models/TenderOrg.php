<?php

namespace Dot\Tenders\Models;

use Dot\Media\Models\Media;
use Dot\Platform\Model;
use Dot\Users\Models\User;


/**
 * Class TenderOrg
 * @package Dot\TenderOrg\Models
 */
class TenderOrg extends Model
{

    /**
     * @var string
     */
    protected $table = 'tender_orgs';
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
        'name' => 'required',
        'logo_id'=>'required|not_in:0'
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
        'name' => 'required',
        'logo_id'=>'required|not_in:0'

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
        return trans('tenders::orgs.attributes');
    }

    /**
     * User relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }


    /**
     * Image relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function logo()
    {
        return $this->hasOne(Media::class, "id", "logo_id");
    }


}
