<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use HasFactory;

    protected $fillable = ['name', 'office_id'];

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function data_table(){
        return $this->hasMany(DataTable::class);
    }
}
