<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'position_id', 'superior_id', 'start_date', 'end_date'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get employee's superior
     */
    public function superior()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get superior's employees
     */
    public function superiorEmployees()
    {
        return $this->hasMany('App\Models\Employee', 'superior_id');
    }

    /**
     * Get employee position
     */
    public function position()
    {
        return $this->belongsTo('App\Models\Position');
    }
}
