<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name'         => 'required|string|max:255',
            'nis' => 'required|numeric|digits:10|unique:users,nis',
            'email'        => [
            'required',
            'email',
            // Hanya cek unique untuk user yang TIDAK soft deleted
            Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password'     => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:13',
            'class'        => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'gender'       => 'required|in:Laki-laki,Perempuan',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.max' => 'Nomor telepon maksimal 13 karakter.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.numeric'  => 'NIS harus berupa angka.',
            'nis.digits'   => 'NIS harus berjumlah 10 digit.',
            'nis.unique'   => 'NIS sudah terdaftar.',
            'class.required' => 'Kelas wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib diisi.',
        ];
    }
}
