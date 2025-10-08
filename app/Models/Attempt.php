<?php

namespace App\Models;//where class model lives

use Illuminate\Database\Eloquent\Factories\HasFactory;//import hasfactory trait
use Illuminate\Database\Eloquent\Model;//import eloquent model

class Attempt extends Model
{
    use HasFactory;

    protected $table = 'attempts';

    protected $fillable = [
        'member_id',
        'quiz_id',
        'started_at',
        'end_at',
        'marks',
    ];

    protected $casts =
    [
        'started_at' => 'datetime',
        'end_at' => 'datetime',
    ];


    //attempt related by members
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    //attempt belongs to quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    //this attempt has many answers
    public function answers()
    {
        return $this->hasMany(UserAnswer::class, 'attempt_id');
    }
}

