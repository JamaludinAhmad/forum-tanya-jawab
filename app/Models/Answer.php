<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'text',
        'question_id',
        'user_id',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function questions(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }



}
