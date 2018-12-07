<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Companies_empolyees extends Model
{
    protected $table = 'companies_employees';

    protected $fillable = ['company_id', 'employee_id', 'status', 'role', 'accepted'];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'employee_id');
    }
}
