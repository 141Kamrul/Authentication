<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTable extends Model
{
    /** @use HasFactory<\Database\Factories\DataTableFactory> */
    use HasFactory;

    protected $fillable = ['name', 'position_id', 'age', 'start_date', 'salary', 'postion_id'];

    public function position(){
        return $this->belongsTo(Position::class);
    }
}
