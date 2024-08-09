<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMsCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required',
            'alamat' => 'required',
            'phone' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama Customer harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'phone.required' => 'No. Telp harus diisi',
            'phone.numeric' => 'No. Telp harus berisi angka',
        ];
    }
}
