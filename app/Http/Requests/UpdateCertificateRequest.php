<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Illuminate\Validation\Rule;

class UpdateCertificateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('certificate_access');
    }

    public function rules()
    {
        // Get the certificate ID from the route
        $certificate = $this->route('certificate');
        $certificateId = $certificate ? $certificate->id : null;

        return [
            'batch_id' => ['integer', 'required'],
            'course_id' => ['required'],
            'student_id' => ['integer', 'required'],
            'type' => ['required', Rule::in(['regular', 'test'])],
            'certificate_number' => [
                'required', 
                'string', 
                Rule::unique('certificates')->ignore($certificateId)
            ],
            'contact_hour' => 'required',
            'issue_date' => 'required|date',
            'test_date' => 'required_if:type,test',
            'mark_obtained' => 'required_if:type,test',
            'grade' => 'required_if:type,test',
            'recommendation' => 'required_if:type,test',
            'certificate_format' => ['required', Rule::in(['old', 'new'])],
            'image' => 'nullable|sometimes|image|mimes:jpeg,jpg,png|max:2048',
            'pdf' => 'nullable|sometimes|file|mimes:pdf|max:20000',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Student is required',
            'batch_id.required' => 'Batch is required',
            'course_id.required' => 'Course is required',
            'certificate_format.required' => 'Certificate format is required',
            'certificate_format.in' => 'Certificate format must be either old or new',
            'image.image' => 'The image must be a valid image file',
            'image.mimes' => 'The image must be a JPEG, JPG, or PNG file',
            'image.max' => 'The image must not be larger than 2MB',
            'pdf.mimes' => 'The PDF must be a valid PDF file',
            'pdf.max' => 'The PDF must not be larger than 20MB',
        ];
    }
}