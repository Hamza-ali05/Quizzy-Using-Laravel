<?php

namespace App\Models;//define model location

use Illuminate\Database\Eloquent\Factories\HasFactory;//import hasfactory trait
use Illuminate\Database\Eloquent\Model;//import eloquent trait

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'quiz_id',
        'questions_text',
    ];

    // add an accessor so $question->text works where views expect it
    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['questions_text'] ?? null;
    }

    //A question belongs to a quiz.
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    
    //A question has many options (if you will create an options table).
    public function options()
    {
        return $this->hasMany(Option::class, 'question_id');
    }
}

