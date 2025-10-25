<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'mission',
        'vision',
        'image',
        'created_at',
        'updated_at',
    ];
}
