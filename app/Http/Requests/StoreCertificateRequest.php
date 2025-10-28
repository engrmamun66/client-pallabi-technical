<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Illuminate\Validation\Rule;

class StoreCertificateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('certificate_access');
    }

    public function rules()
    {
        return [
            'batch_id' => ['integer', 'required'],
            'course_id' => ['required'],
            'student_id' => ['integer', 'required'],
            'type' => ['required', Rule::in(['regular', 'test'])],
            'certificate_number' => 'required|string|unique:certificates,certificate_number',
            'contact_hour' => 'required',
            'issue_date' => 'required|date',
            'test_date' => 'required_if:type,test',
            'mark_obtained' => 'required_if:type,test',
            'grade' => 'required_if:type,test',
            'recommendation' => 'required_if:type,test',
            'image' => 'required_if:certificate_format,old|image|mimes:jpeg,jpg,png|max:2048', // 2MB max
            'pdf' => 'required_if:certificate_format,old|file|mimes:pdf|max:20000', // 5MB max, optional
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Student is required',
            'batch_id.required' => 'Batch is required',
            'course_id.required' => 'Course is required',
            'image.required' => 'Certificate image is required',
            'image.image' => 'The image must be a valid image file',
            'image.mimes' => 'The image must be a JPEG, JPG, or PNG file',
            'image.max' => 'The image must not be larger than 2MB',
            'pdf.mimes' => 'The PDF must be a valid PDF file',
            'pdf.max' => 'The PDF must not be larger than 5MB',
        ];
    }
}