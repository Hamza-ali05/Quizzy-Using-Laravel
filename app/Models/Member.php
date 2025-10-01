<?php

namespace App\Models;//where class model lives

use Illuminate\Database\Eloquent\Factories\HasFactory;//import hasfactory trait
use Illuminate\Foundation\Auth\User as Authenticatable; // Important for manual auth
use Illuminate\Notifications\Notifiable;//send notifactions through sms or emails

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'members'; // table name

    protected $fillable = [//values should be mass-assigned like for create() and update of model
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [//keep password hidden
        'password',
    ];

    public function quizzes()// for admin
    {
        return $this->hasMany(Quiz::class, 'created_by');
    }
    public function results()   // for student
    {
        return $this->hasMany(Result::class, 'student_id');
    }
}
