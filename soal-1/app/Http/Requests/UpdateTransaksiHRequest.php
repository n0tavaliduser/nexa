<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransaksiHRequest extends FormRequest
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
            'nomor_transaksi' => 'required|string',
            'tanggal_transaksi' => 'required|date',
            'customer_id' => 'required|exists:ms_customer,id',
            'nama_customer' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'total' => 'required|numeric|min:0',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'kd_barang' => 'required|array',
            'kd_barang.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'subtotal' => 'required|array',
            'subtotal.*' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nomor_transaksi.required' => 'Nomor Transaksi harus diisi.',
            'tanggal_transaksi.required' => 'Tanggal Transaksi harus diisi.',
            'customer_id.required' => 'Nama Customer harus diisi.',
            'customer_id.exists' => 'Nama Customer tidak ditemukan.',
            'nama_customer.required' => 'Nama Customer harus diisi.',
            'nama_customer.max' => 'Nama Customer tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'phone.required' => 'No. HP harus diisi.',
            'phone.max' => 'No. HP tidak boleh lebih dari 15 karakter.',
            'nama_barang.required' => 'Nama Barang harus diisi.',
            'nama_barang.*.required' => 'Nama Barang harus diisi.',
            'kd_barang.required' => 'Kode Barang harus diisi.',
            'kd_barang.*.required' => 'Kode Barang harus diisi.',
            'qty.required' => 'Qty harus diisi.',
            'qty.*.integer' => 'Qty harus berupa angka.',
            'qty.*.min' => 'Qty minimal 1.',
            'subtotal.required' => 'Subtotal harus diisi.',
            'subtotal.*.numeric' => 'Subtotal harus berupa angka.',
            'subtotal.*.min' => 'Subtotal tidak boleh kurang dari 0.',
            'total.required' => 'Total harus diisi.',
            'total.numeric' => 'Total harus berupa angka.',
            'total.min' => 'Total tidak boleh kurang dari 0.',
        ];
    }
}
