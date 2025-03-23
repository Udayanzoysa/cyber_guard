<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'quiz_score',
        'achieved_score',
        'storage_dovice_score',
        'transmission_browsing_score',
        'social_media_score',
        'authentication_score',
        'messaging_score'
    ];

    public function quiz()
    {
        $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        $this->belongsToMany(User::class);
    }
}
