<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegisterRequest extends FormRequest
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
            'name'     => 'required|string|max:255',
            'nis'  => [
                'required',
                'numeric', 
                'digits:10',
                'unique:users,nis' 
            ],
            'email'    => [
                'required',
                'email',
                'max:255',
                // Hanya cek unique untuk user yang TIDAK soft deleted
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'nis.required'  => 'NIS wajib diisi.',
            'nis.numeric'   => 'NIS harus berupa angka.',
            'nis.digits'    => 'NIS harus berjumlah 10 digit.',
            'nis.unique'    => 'NIS ini sudah digunakan oleh siswa lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
