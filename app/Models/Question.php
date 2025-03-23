<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'question', 'type', 'options', 'correct_answer'];

    protected $casts = [
        'options' => 'array', // To handle JSON data
    ];

    public function quiz(){
        $this->belongsToMany(Quiz::class);
    }
}
