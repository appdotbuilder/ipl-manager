<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIplPaymentRequest extends FormRequest
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
            'resident_id' => 'required|exists:residents,id',
            'nominal_ipl' => 'required|numeric|min:0',
            'tahun_periode' => 'required|integer|min:2020|max:2050',
            'bulan_ipl' => [
                'required',
                Rule::in([
                    'januari', 'februari', 'maret', 'april', 'mei', 'juni',
                    'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
                ])
            ],
            'status_pembayaran' => 'required|in:paid,unpaid,exempt',
            'rumah_kosong' => 'boolean',
            'notes' => 'nullable|string|max:1000',
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
            'resident_id.required' => 'Warga harus dipilih.',
            'resident_id.exists' => 'Warga yang dipilih tidak valid.',
            'nominal_ipl.required' => 'Nominal IPL wajib diisi.',
            'nominal_ipl.numeric' => 'Nominal IPL harus berupa angka.',
            'tahun_periode.required' => 'Tahun periode wajib diisi.',
            'tahun_periode.integer' => 'Tahun periode harus berupa angka.',
            'bulan_ipl.required' => 'Bulan IPL wajib dipilih.',
            'bulan_ipl.in' => 'Bulan IPL tidak valid.',
            'status_pembayaran.required' => 'Status pembayaran wajib dipilih.',
        ];
    }
}