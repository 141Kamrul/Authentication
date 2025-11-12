<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use HasFactory;

    protected $fillable = ['name', 
        'office_id', 
        'total_employee_count',
        'hired_employee_count',
    ];

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function data_tables(){
        return $this->hasMany(DataTable::class);
    }
}
