<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;

class AddEmployeeRequest extends FormRequest
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
            'fname' => 'required',
            'lname' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'civil_status_id' => 'required',
            'gender' => 'required',
            'per_address' => 'required',
            'contact_num' => 'required',
            'email' => 'required|unique:employee_personal_details',
            'image' => 'base64image',
            'employee_id' => 'required|unique:employee_employment_details',
            'tin_no' => 'required|unique:employee_employment_details',
            'role_type' => 'required',
            'employment_status_id' => 'required',
            'job_code' => 'required',
            'date_join' => 'required',
            'date_appoint' => 'required',
            'work_shift' => 'required',
            'item_num' => 'required',
        ];
    }
}
