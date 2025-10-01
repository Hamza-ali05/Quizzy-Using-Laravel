<?php

namespace App\Models;//define the models locations

use Illuminate\Database\Eloquent\Factories\HasFactory;//import hasfactory trait 
use Illuminate\Database\Eloquent\Model;//import eloquent 

class Option extends Model
{
    use HasFactory;

    protected $table = 'options';

    // Fillable fields for mass assignment
    protected $fillable = [
        'question_id',
        'option_s',
        'correct_option',
    ];

    // Cast correct_option to boolean automatically
    protected $casts = [
        'correct_option' => 'boolean',
    ];

    protected $appends = ['option_text'];

    public function getOptionTextAttribute()
    {
        return $this->attributes['option_s'] ?? null;
    }

    //each option belongs to a question
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}

