<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'name',
    ];

    public function course(){
        return $this->belongsTo('App\Http\Models\Course', 'course_id');
    }

    public function questions(){
        return $this->hasMany('App\Http\Models\Question', 'test_id');
    }
}
