@extends('admin.layouts.app')

@section('title', 'Kelola Anggota')

@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/admin/users/index.css') }}">
@endpush

@section('content')
<x-breadcrumb 
    title="Daftar Pengguna"
    description="Kelola informasi anggota perpustakaan"
    category="Manajemen"
    bgColor="var(--hero-bg)" 
/>

<div class="w-100 mb-3">
    <x-search-filter :action="url()->current()" placeholder="Cari nama atau email...">
        <div class="control-wrapper d-flex align-items-center justify-content-between w-100 flex-wrap gap-3">
            <!-- Filter Kelas -->
            <div class="filter-group d-flex align-items-center">
                <select name="class" 
                    class="form-select modern-input auto-submit"
                    style="min-width: 150px; height: 45px; border-radius: 12px;">
                    <option value="">Semua Kelas</option>
                    <option value="10" {{ request('class') == '10' ? 'selected' : '' }}>Kelas 10</option>
                    <option value="11" {{ request('class') == '11' ? 'selected' : '' }}>Kelas 11</option>
                    <option value="12" {{ request('class') == '12' ? 'selected' : '' }}>Kelas 12</option>
                </select>
            </div>

            <!-- Action Buttons RESPONSIVE -->
            <div class="action-buttons d-flex gap-2 flex-wrap">
                <button type="button" id="btn-bulk-delete"
                    class="btn btn-danger d-flex align-items-center gap-2 px-3">
                    <i class="bi bi-trash3-fill"></i>
                    <span>Hapus</span>
                </button>
                <a href="{{ route('admin.users.create') }}"
                    class="btn text-white d-flex align-items-center gap-2 px-3 text-nowrap"
                    style="background-color: #1e1e1e; border-radius: 12px;">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Tambah Pengguna</span>
                </a>
            </div>
        </div>
    </x-search-filter>
</div>

<form action="{{ route('admin.users.bulkDestroy') }}" method="POST" id="form-bulk-delete">
    @csrf
    @method('DELETE')
    <div class="table-responsive shadow-sm mb-4 mt-4"
        style="border-radius: 15px; background: white; border: 1px solid #eee;">
        <table class="table border-0 text-nowrap customize-table mb-0 align-middle">
            <thead>
                <tr style="background-color: #1e1e1e !important; color: #ffffff !important;">
                    <th class="py-3 ps-4" style="background: #1e1e1e !important; border: none;">
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-check-input mt-0" type="checkbox" id="check-all" style="cursor: pointer;">
                            <label for="check-all" class="mb-0 fw-bold" style="cursor: pointer; font-size: 12px; color: #ffffff !important;">ALL</label>
                        </div>
                    </th>
                    <th class="fw-bold py-3 text-start" style="background: #1e1e1e !important; color: #ffffff !important; border: none;">No</th>
                    <th class="fw-bold py-3 text-center" style="background: #1e1e1e !important; color: #ffffff !important; border: none;">Nama Pengguna</th>
                    <th class="fw-bold py-3 text-start" style="background: #1e1e1e !important; color: #ffffff !important; border: none;">NIS</th>
                    <th class="fw-bold py-3" style="background: #1e1e1e !important; color: #ffffff !important; border: none;">No Telepon</th>
                    <th class="fw-bold py-3 text-center" style="background: #1e1e1e !important; color: #ffffff !important; border: none;">Kelas</th>
                    <th class="fw-bold py-3 text-center" style="background: #1e1e1e !important; color: #ffffff !important; border: none;">Jenis Kelamin</th>
                    <th class="fw-bold py-3 text-center" style="background: #1e1e1e !important; color: #ffffff !important; border: none;">Alamat</th>
                    <th class="fw-bold py-3 text-center" style="background: #1e1e1e !important; color: #ffffff !important; border: none;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                <tr class="user-row" style="border-bottom: 1px solid #f8f9fa;">
                    <td class="ps-4">
                        <div class="form-check d-flex justify-content-start">
                            <input class="form-check-input user-checkbox" type="checkbox" name="ids[]" value="{{ $user->id }}" id="user{{ $user->id }}">
                        </div>
                    </td>
                    <td class="text-left text-muted">{{ $users->firstItem() + $index }}</td>
                    <td style="padding: 14px 16px;">
                        <div class="d-flex align-items-center gap-3">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" 
                                    class="rounded-circle shadow-sm flex-shrink-0"
                                    style="width: 44px; height: 44px; object-fit: cover; border: 2px solid #f0ebe2;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 44px; height: 44px; background: #f0ebe2; border: 1px solid #e5e0d8;">
                                    <i class="bi bi-person-fill" style="font-size: 18px; color: #ad9a79;"></i>
                                </div>
                            @endif
                            <div style="min-width: 0;">
                                <div class="fw-bold text-truncate" style="color: #1e1e1e; font-size: 13.5px; max-width: 150px;">
                                    {{ $user->name ?? '-' }}
                                </div>
                                <div class="text-truncate" style="font-size: 11.5px; color: #8e8e8e; max-width: 150px;">
                                    <i class="bi bi-envelope me-1"></i>{{ $user->email ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted" style="font-size: 13px;">{{ $user->nis ?? '-' }}</td>
                    <td class="text-muted" style="font-size: 13px;">{{ $user->phone_number ?? '-' }}</td>
                    <td class="text-center"><span class="badge bg-light text-dark border fw-medium px-3 py-2" style="border-radius: 8px; font-size: 11px;">{{ $user->class ?? '-' }}</span></td>
                    <td class="text-muted text-center" style="font-size: 13px;">{{ $user->gender ?? '-' }}</td>
                    <td class="text-muted text-start align-middle" style="font-size: 14px; max-width: 180px; white-space: normal; line-height: 1.2;">
                        {{ Str::limit($user->address ?? '-', 70, '...') }}
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2 action-buttons-table">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn p-0 d-flex align-items-center justify-content-center shadow-sm" style="background-color: var(--accent); border-radius: 10px; width: 34px; height: 34px; transition: 0.3s;" title="Edit">
                                <i class="bi bi-pencil-square text-white" style="font-size: 14px;"></i>
                            </a>

                            <button type="button" class="btn p-0 d-flex align-items-center justify-content-center shadow-sm btn-detail"
                                    style="background-color: #6c757d; border-radius: 10px; width: 34px; height: 34px; border:none; transition: 0.3s;" title="Detail"
                                    data-bs-toggle="modal" data-bs-target="#modalDetail"
                                    data-photo="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/no-profile.jpeg') }}"
                                    data-name="{{ $user->name ?? '-' }}"
                                    data-nis="{{ $user->nis ?? '-' }}"
                                    data-email="{{ $user->email ?? '-' }}"
                                    data-phone="{{ $user->phone_number ?? '-' }}"
                                    data-class="{{ $user->class ?? '-' }}"
                                    data-address="{{ $user->address ?? '-' }}"
                                    data-gender="{{ $user->gender ?? '-' }}">
                                <i class="bi bi-eye-fill text-white" style="font-size: 14px;"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <x-empty-state
                            colspan="9" 
                            description="Belum ada data pengguna yang tercatat."
                        />
                    </td>
                @endforelse
            </tbody>
        </table>
    </div>
</form>

<div class="mt-4">
    <x-paginate :paginator="$users"></x-paginate>
</div>

@include('admin.pages.users.widgets.detail-profile-modal')
@endsection

@push('scripts')
    @include('admin.pages.users.scripts.index')
@endpush