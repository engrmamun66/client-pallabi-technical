<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'certificate_number',
        'image',
        'type',
        'pdf_path',
        'batch_id',
        'student_id',
        'contact_hour',
        'test_date',
        'issue_date',
        'mark_obtained',
        'grade',
        'recommendation',
        'is_old',
        'certificate_format',
        'version_history',
        'is_download',

    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the course that owns the certificate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

/*******  44aad4be-b056-4f9b-98a3-789f5ee55d37  *******/

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

