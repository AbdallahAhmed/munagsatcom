<?php

namespace Dot\Companies\Models;

use App\Models\Companies_empolyees;
use DB;
use Dot\Media\Models\Media;
use Dot\Platform\Model;
use Dot\Users\Models\User;

/*
 * Class Company
 * @package Dot\Categories\Models
 */
class Company extends Model
{

    /*
     * @var string
     */
    protected $module = 'companies';

    /*
     * @var string
     */
    protected $table = 'companies';

    /*
     * @var string
     */
    protected $primaryKey = 'id';

    public $timestamps = true;

    /*
     * @var array
     */
    protected $fillable = array('*');

    /*
     * @var array
     */
    protected $guarded = array('id');

    /*
     * @var array
     */
    protected $visible = array();

    /*
     * @var array
     */
    protected $hidden = array();

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
        "first_name" => "required",
        "last_name" => "required"
    ];

    /*
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
        "first_name" => "required",
        "last_name" => "required",
        'block_reason' => "required_if:blocked,==,1"
    ];

    /*
     * image relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function image()
    {
        return $this->hasOne(Media::class, "id", "image_id");
    }

    /*
     * user relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    function files(){
        return $this->belongsToMany(Media::class, 'companies_files', 'company_id', 'file_id');
    }

    function rrequests(){
        return $this->belongsToMany(User::class, 'users_requests', 'receiver_id', 'sender_id');
    }

    function srequests(){
        return $this->belongsToMany(User::class, 'companies_requests', 'sender_id', 'receiver_id');
    }

    function employees(){
        return $this->belongsToMany(User::class, 'companies_employees', 'company_id', 'employee_id');
    }

}

