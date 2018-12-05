<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies_empolyees extends Model
{
    protected $table = 'companies_employees';
    protected $fillable = ['company_id', 'employee_id', 'status', 'role', 'accepted'];
    public $timestamps = false;
}
