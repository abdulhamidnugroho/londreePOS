<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'nama' => 'required',
            'email' => 'required|email|unique:admin',
            'telp' => 'required|unique:admin',
            'password' => 'required'
        ];
    }
    
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
	{
		return [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique:admin' => 'Email sudah terpakai',
            'password.required' => 'Password harus diisi'
		];
	}
}
