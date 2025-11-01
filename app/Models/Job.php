<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;
    protected $table = "jobs_listings";
    protected $fillable = ['title', 'salary', 'employer_id'];

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'job_tag', 'jobs_listings_id', 'tag_id');
    }

    public function tag(string $name){
        $tag=Tag::firstOrCreate(['name' => $name]);
        $this->tags()->attach($tag);
    }
}
