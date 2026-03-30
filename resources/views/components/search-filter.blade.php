@props(['action', 'placeholder' => 'Cari sesuatu...'])

<form action="{{ $action }}" method="GET" class="mb-4" id="filterForm">
    <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <div class="search-container position-relative">
                <div class="search-icon-wrapper position-absolute top-50 translate-middle-y ps-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted opacity-50">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control modern-input ps-5 auto-submit" placeholder="{{ $placeholder }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex align-items-center gap-2 justify-content-end custom-filter-slot">
                {{ $slot }}
            </div>
        </div>
    </div>
</form>

@push('scripts')
    @include('components.scripts.search-filter')
@endpush