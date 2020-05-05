<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'text', 'is_correct',
    ];

    public function question(){
        return $this->belongsTo('App\Http\Models\Question', 'question_id');
    }

    public function passed_questions(){
        return $this->hasMany('App\Http\Models\PassedQuestion', 'answer_id');
    }
}
