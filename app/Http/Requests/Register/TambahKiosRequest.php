<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class TambahKiosRequest extends FormRequest
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
            'alamat' => 'required|',
            'no_telp' => 'required|unique:admin',
            'id_owner' => 'required'
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
            'alamat.required' => 'Alamat harus diisi',
            'no_telp.unique:admin' => 'No Telepon sudah terpakai',
            'id_owner' => 'required'
		];
	}
}
