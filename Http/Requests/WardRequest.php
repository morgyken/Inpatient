<?php 

namespace Ignite\Inpatient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WardRequest extends FormRequest
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
            'name' => 'required|unique:inpatient_wards',
            'cash_cost' => 'numeric',
            'insurance_cost' => 'numeric'
        ];
    }

    public function messages()
    {
        return [
            'number.unique' => 'The ward number already exists',
        ];
    }
}
