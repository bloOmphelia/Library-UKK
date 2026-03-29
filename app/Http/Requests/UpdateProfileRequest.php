<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $userId = auth()->id();

        // 1. Jika tombol "Nanti Saja" (skip) diklik, matikan semua validasi
        if ($this->input('action') === 'skip') {
            return [];
        }

        // 2. Deteksi apakah request datang dari halaman "Lengkapi Profil" (Register)
        // Sesuaikan 'register.update' dengan nama route di web.php kamu
        $isRegisterFlow = $this->routeIs('register.update');

        // Aturan: Jika di alur register = required, jika di dashboard = nullable
        $status = $isRegisterFlow ? 'required' : 'nullable';

        return [
            'name'         => 'sometimes|required|string|max:255',
            'email'        => 'sometimes|required|email|unique:users,email,' . $userId,
            'phone_number' => $status . '|string|max:13',
            'class'        => $status . '|string|max:255',
            'address'      => $status . '|string|max:255',
            'gender'       => $status . '|in:Laki-laki,Perempuan',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Nama wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.max'      => 'Nomor telepon maksimal 13 karakter.',
            'class.required'        => 'Kelas wajib diisi.',
            'address.required'      => 'Alamat wajib diisi.',
            'photo.image'           => 'File harus berupa gambar.',
            'photo.mimes'           => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'photo.max'             => 'Ukuran gambar maksimal 2MB.',
            'gender.required'       => 'Jenis kelamin wajib dipilih.',
        ];
    }
}
