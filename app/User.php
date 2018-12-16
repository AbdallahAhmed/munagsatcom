<?php

namespace App;

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
}
