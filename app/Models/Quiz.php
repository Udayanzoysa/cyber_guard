<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable=[
      'title',
      'duration',
      'from_time',
      'to_time',
      "base_quiz",
    ];

    public function question(){
        return $this->hasMany(Question::class);
    }

    public function result(){
        $this->hasMany(Result::class);
    }
}
