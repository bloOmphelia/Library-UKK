<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user');

        return [
            'name'         => 'sometimes|required|string|max:255',
            'nis' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('users', 'nis')->ignore($userId)->whereNull('deleted_at'),
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId)->whereNull('deleted_at'),
            ],
            'password'     => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:13',
            'class'        => 'nullable|string|max:255',
            'address'      => 'nullable|string|max:255',
            'gender'       => 'nullable|in:Laki-laki,Perempuan',
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
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone_number.max' => 'Nomor telepon maksimal 13 karakter.',
        ];
    }
}
