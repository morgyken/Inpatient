<?php

namespace Ignite\Inpatient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:inpatient_admission_types',
            'deposit' => 'required'
        ];
    }
}
