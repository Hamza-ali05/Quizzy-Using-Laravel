<?php

namespace App\Models;//define model class

use Illuminate\Database\Eloquent\Factories\HasFactory;//import hasfactory trait
use Illuminate\Database\Eloquent\Model;//import eloquent by laravel

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [//used table values may be mass-assigned
        'attempt_id',
        'question_id',
        'option_id',
        'correct',
    ];

    

    //result belong to an attempts
    public function attempt()
    {
        return $this->belongsTo(Attempt::class, 'attempt_id');
    }

    //result belong to a questions 
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    //question belong to an option which is choosen
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
    public function quiz()
{
    return $this->belongsTo(Quiz::class);
}

public function student()
{
    return $this->belongsTo(Member::class, 'student_id');
}

}

