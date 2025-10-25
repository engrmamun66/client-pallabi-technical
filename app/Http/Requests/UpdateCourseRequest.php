<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_access');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ]
        ];
    }
}
