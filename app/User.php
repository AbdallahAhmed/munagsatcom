<?php

namespace App;

use App\Models\Companies_empolyees;
use App\Models\Company;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \Dot\Users\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function requests()
    {
        return $this->belongsToMany(Company::class, 'users_requests', 'sender_id', 'receiver_id');
    }

    public function rrequests()
    {
        return $this->belongsToMany(Company::class, 'companies_requests', 'receiver_id', 'sender_id');
    }

    public function company()
    {
        return $this->belongsToMany(Company::class, 'companies_employees', 'employee_id', 'company_id')->withPivot(['role']);
    }

    /**
     * Is owner or not
     * @return bool
     */
    public function getIsOwnerAttribute()
    {
        if (isset($this->original['IsOwner_cache'])) {
            return $this->original['IsOwner_cache'];
        }
        return $this->original['IsOwner_cache'] = Company::where('user_id', $this->id)->count() > 0;
    }

    /**
     * Is in Company
     * @return bool
     */
    public function getInCompanyAttribute()
    {
        if ($this->is_owner) {
            return true;
        }

        if (isset($this->original['IsCompany_cache'])) {
            return $this->original['IsCompany_cache'];
        }
        return $this->original['IsCompany_cache'] = Companies_empolyees::where(['employee_id' => $this->id, 'accepted' => 1, 'status' => 1])->count() > 0;
    }
}
