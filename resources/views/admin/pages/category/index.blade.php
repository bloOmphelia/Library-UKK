@extends('admin.layouts.app')

@section('title', 'Kategori Buku')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/category/index.css') }}">
@endpush

@section('content')
<x-breadcrumb 
    title="Kelola Kategori Buku"
    description="Atur kategori untuk klasifikasi buku"
    category="Manajemen"
    bgColor="#f2f0eb"
/>

<div class="container-fluid p-4">

    <x-search-filter :action="url()->current()" placeholder="Cari nama kategori...">
        <div class="d-flex align-items-center justify-content-end w-100">
            <a href="{{ route('admin.category.create') }}" 
            class="btn btn-dark d-flex align-items-center justify-content-center gap-2 text-nowrap" 
            style="height: 45px; padding: 0 20px; border-radius: 12px; font-size: 14px; font-weight: 700;">
                <i class="bi bi-plus-lg" style="font-size: 18px;"></i>
                Tambah Kategori
            </a>
        </div>
    </x-search-filter>

    <div class="table-responsive">
        <table class="table customize-table mb-0 align-middle text-center">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="65%" class="text-start ps-5">Nama Kategori</th>
                    <th width="25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $index => $category)
                <tr>
                    <td class="fw-bold text-muted">{{ $categories->firstItem() + $index }}</td>
                    <td class="text-start ps-5">
                        <span class="fw-semibold" style="color: #1e1e1e;">{{ $category->name }}</span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.category.edit', $category->id) }}" 
                                class="btn btn-sm text-white" 
                                style="background-color: #ad9a79; border-radius: 6px;"
                                title="Edit Kategori">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18.5 2.5C19.3284 1.67157 20.6716 1.67157 21.5 2.5C22.3284 3.32843 22.3284 4.67157 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <form action="{{ route('admin.category.destroy', $category->id) }}" 
                                  method="POST" class="d-inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger p-2 d-flex align-items-center shadow-sm swal-delete" >
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 6H5H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <x-empty-state
                    colspan="3" 
                    description="Belum ada kategori yang ditambahkan."
                />
                @endforelse
            </tbody>
        </table>
    </div>
 
    <div class="mt-4">
        <x-paginate :paginator="$categories" />
    </div>
</div>
@endsection