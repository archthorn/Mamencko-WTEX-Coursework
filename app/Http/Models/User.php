<?php

namespace App\Http\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function createdCourses(){
        return $this->hasMany('App\Http\Models\Course', 'created_by');
    }

    public function courses(){
        return $this->belongsToMany('App\Http\Models\Course', 'subscriptions');
    }

    public function passed_questions(){
        return $this->hasMany('App\Http\Models\PassedQuestion', 'user_id');
    }
}
