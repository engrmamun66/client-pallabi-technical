<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'course_name',
        'description',
        'image',
        'price',
        'duration',
        'duration_type',
        'created_at',
        'updated_at',
    ];

    protected $append = ['duration_type'];

    public function getDurationTypeAttribute()
    {
        return ucFirst($this->attributes['duration_type']);
    }
}
