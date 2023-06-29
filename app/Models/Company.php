<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $table = 'companies';

    protected $fillable = [
        'name',

    ];

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }
    public function subgroups()
    {
        return $this->hasMany(SubGroup::class);
    }
    public function bureaus()
    {
        return $this->hasMany(Bureau::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }
}
