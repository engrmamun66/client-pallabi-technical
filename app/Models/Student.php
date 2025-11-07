<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'name',
        'nid_or_passport', 
        'fathers_name', 
        'address', 
        'last_completed_certificate_name', 
        'year_of_course_complete',
        'mobile',
        'created_at',
        'updated_at',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
