@extends('admin.layouts.app')

@section('title', 'Kelola Anggota')

@section('content')
<div class="card position-relative overflow-hidden" style="background-color: #E8DEF3;">
    <div class="card-body px-4 py-4">
        <div class="row align-items-center">
            <div class="col-9">
                @include('components.breadcrumb', [
                    'title' => 'Daftar Pengguna',
                    'description' => 'Kelola informasi anggota perpustakaan'
                ])
            </div>
            <div class="col-3 text-center mb-n1">
                <img src="{{ asset('assets/users/admin/dist/images/backgrounds/track-bg.png') }}" 
                     width="70px" alt="" class="img-fluid mb-n3" />
            </div>
        </div>
    </div>
</div>

<div class="p-3 mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-2">
        
        <div class="flex-grow-1 w-100" style="max-width: 800px;">
            <x-search-filter :action="url()->current()" placeholder="Cari nama atau email..."></x-search-filter>
        </div>

        <div>
            <a href="{{ route('admin.users.create') }}" 
               class="btn text-white d-flex align-items-center gap-2" style="background-color: #7209DB; padding: 10px 20px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z" />
                </svg>
                <span>Tambah <span class="d-none d-sm-inline">Pengguna</span></span>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive rounded-2 mb-4 mt-4">
        <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
            <thead>
                <tr>
                    <th class="fw-semibold text-white" style="background-color: #9425FE">No</th>
                    <th class="fw-semibold text-white" style="background-color: #9425FE">Nama Pengguna</th>
                    <th class="fw-semibold text-white" style="background-color: #9425FE">Email</th>
                    <th class="fw-semibold text-white" style="background-color: #9425FE">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($users as $index => $user)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="btn action-btn" 
                               style="background-color: #FFB649;" title="Edit">
                                <svg width="18" height="18" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.4582 7.98781L14.178 4.70855L15.4907 3.39684C16.0751 2.81242 17.4137 2.69646 18.1141 3.39684L18.7699 4.05269C19.4703 4.75307 19.3553 6.09168 18.7699 6.67703L17.4582 7.98781ZM16.1465 9.30044L6.96272 18.4842L2.69922 19.4675L3.68253 15.204L12.8663 6.02025L16.1465 9.30044Z" fill="white" />
                                </svg>
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn action-btn" style="background-color: #DB0909;"
                                        onclick="return confirm('Hapus anggota ini?')" title="Hapus">
                                    <svg width="18" height="18" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_10766_43089)">
                                            <path d="M3.71094 6.49219H18.5534" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M9.27734 10.2031V15.7691" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12.9883 10.2031V15.7691" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M4.63672 6.49219L5.56437 17.6241C5.56437 18.1161 5.75984 18.588 6.10778 18.936C6.45572 19.2839 6.92763 19.4794 7.41968 19.4794H14.8409C15.333 19.4794 15.8049 19.2839 16.1528 18.936C16.5008 18.588 16.6962 18.1161 16.6962 17.6241L17.6239 6.49219" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M8.34766 6.49187V3.70891C8.34766 3.46288 8.44539 3.22692 8.61936 3.05295C8.79333 2.87898 9.02928 2.78125 9.27531 2.78125H12.9859C13.232 2.78125 13.4679 2.87898 13.6419 3.05295C13.8159 3.22692 13.9136 3.46288 13.9136 3.70891V6.49187" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_10766_43089">
                                                <rect width="22.2637" height="22.2637" rx="6" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Belum ada anggota ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection