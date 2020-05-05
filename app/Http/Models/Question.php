<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'text', 'type',
    ];

    public function test(){
        return $this->belongsTo('App\Http\Models\Test', 'test_id');
    }

    public function answers(){
        return $this->hasMany('App\Http\Models\Answer', 'question_id');
    }

    public function passed_questions(){
        return $this->hasMany('App\Http\Models\PassedQuestion', 'question_id');
    }
}
