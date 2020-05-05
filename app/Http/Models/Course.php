<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'subject','description', 'is_published',
    ];

    protected $attributes = [
        'is_published' => false,
    ];

    public function author(){
        return $this->belongsTo('App\Http\Models\User', 'created_by');
    }

    public function users(){
        return $this->belongsToMany('App\Http\Models\User', 'subscriptions');
    }

    public function tests(){
        return $this->hasMany('App\Http\Models\Test', 'course_id');
    }
}
