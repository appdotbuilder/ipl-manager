<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResidentRequest extends FormRequest
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
            'nama_warga' => 'required|string|max:255',
            'blok_nomor_rumah' => 'required|string|max:255|unique:residents,blok_nomor_rumah',
            'default_nominal_ipl' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_warga.required' => 'Nama warga wajib diisi.',
            'blok_nomor_rumah.required' => 'Blok dan nomor rumah wajib diisi.',
            'blok_nomor_rumah.unique' => 'Blok dan nomor rumah sudah terdaftar.',
            'default_nominal_ipl.required' => 'Nominal IPL wajib diisi.',
            'default_nominal_ipl.numeric' => 'Nominal IPL harus berupa angka.',
            'default_nominal_ipl.min' => 'Nominal IPL tidak boleh kurang dari 0.',
        ];
    }
}