<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_name',
        'course_id',
        'batch_code',
        'description',
        'status',
    ];

    public function students() {
        return $this->belongsToMany(Student::class, 'batch_students', 'batch_id', 'student_id');
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
