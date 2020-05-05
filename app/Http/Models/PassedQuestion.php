<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PassedQuestion extends Model
{
    protected $fillable = [
        'answer_id', 'is_passed', 'written_answer', 'question_id',
    ];

    public function user(){
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }

    public function question(){
        return $this->belongsTo('App\Http\Models\Question', 'question_id');
    }

    public function answer(){
        return $this->belongsTo('App\Http\Models\Answer', 'answer_id');
    }
}
