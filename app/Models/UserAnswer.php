<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'quiz_id',
        'question_id',
        'option_id',
        'attempt_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }
}
