@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="manage-users-page">

    <h2>Edit Category</h2>

    <form action="{{ route('admin.category.update', $categories->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label class="form-label-dark">
                Name <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" class="form-control form-control-dark" value="{{ old('name', $categories->name) }}">
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
