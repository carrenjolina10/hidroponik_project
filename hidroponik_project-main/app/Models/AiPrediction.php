<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiPrediction extends Model
{
    use HasFactory;

    protected $table = 'ai_predictions';

    protected $fillable = [
        'filename',
        'prediction',
        'confidence',
        'model',
    ];
}