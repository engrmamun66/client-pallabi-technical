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
        return [
            'batch_id' => ['integer','required'],
            'student_id' => ['integer','required'],
            'type' => ['required', Rule::in(['regular', 'test'])],
            'certificate_number' => ['required','string', Rule::unique('certificates')->ignore($this->certificate->id)],
            'contact_hour' => 'required',
            'issue_date' => 'required|date',
            'test_date' => 'required_if:type,test',
            'mark_obtained' => 'required_if:type,test',
            'grade' => 'required_if:type,test',
            'recommendation' => 'required_if:type,test',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Student is required',
            'batch_id.required' => 'Batch is required',
        ];
    }
}
