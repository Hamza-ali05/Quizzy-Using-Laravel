<?php

namespace App\Models;//define model class

use Illuminate\Database\Eloquent\Factories\HasFactory;//import hasfactory trait
use Illuminate\Database\Eloquent\Model;//import eloquent 

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = [
        'title',
        'description',
        'created_by',
        'duration',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
    
    //shows quiz belongs to a creator
    public function creator()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
