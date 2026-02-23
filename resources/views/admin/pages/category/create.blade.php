@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="manage-users-page">

    <h2>Tambah Category</h2>

    <form action="{{ route('admin.category.store') }}" method="POST">
        @csrf
        <div>
            <label class="form-label-dark">
                Name <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" class="form-control form-control-dark">
                @error('name')
            <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div> 

        <div style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('admin.category') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection
