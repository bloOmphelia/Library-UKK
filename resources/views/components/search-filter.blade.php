@props(['action', 'placeholder' => 'Cari...'])

<form action="{{ $action }}" method="GET" class="mb-4" id="filterForm">
    <div class="row g-2">
        <div class="col-md-6">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   class="form-control auto-submit"
                   placeholder="{{ $placeholder }}">
        </div>

        <div class="col-md-4">
            {{ $slot }}
        </div>
    </div>
</form>

@push('scripts')
    @include('components.scripts.search-filter')
@endpush