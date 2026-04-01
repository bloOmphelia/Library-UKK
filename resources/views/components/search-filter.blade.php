@props(['action', 'placeholder' => 'Cari sesuatu...', 'inline' => false])

@if($inline)
    <div class="d-flex align-items-center gap-3 flex-grow-1" style="min-width: 0;">
        <form action="{{ $action }}" method="GET" class="m-0" id="filterForm" style="max-width: 500px; width: 100%;">
            <div class="search-container position-relative">
                <div class="search-icon-wrapper position-absolute top-50 translate-middle-y ps-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted opacity-50">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="form-control modern-input ps-5 auto-submit search-input"
                    placeholder="{{ $placeholder }}"
                    style="{{ request('search') ? 'padding-right: 36px;' : '' }}">
                @if(request('search'))
                    <button type="button" class="btn-clear-search position-absolute top-50 translate-middle-y end-0 me-2 border-0 bg-transparent p-0 d-flex align-items-center justify-content-center" 
                        style="width: 24px; height: 24px; cursor: pointer; opacity: 0.4; transition: opacity 0.15s;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                @endif
            </div>
        </form>

        @if ($slot->isNotEmpty())
            <div class="d-flex align-items-center gap-2 custom-filter-slot">
                {{ $slot }}
            </div>
        @endif
    </div>

@else
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
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="form-control modern-input ps-5 auto-submit search-input"
                        placeholder="{{ $placeholder }}"
                        style="{{ request('search') ? 'padding-right: 36px;' : '' }}">
                    @if(request('search'))
                        <button type="button" class="btn-clear-search position-absolute top-50 translate-middle-y end-0 me-2 border-0 bg-transparent p-0 d-flex align-items-center justify-content-center" 
                            style="width: 24px; height: 24px; cursor: pointer; opacity: 0.4; transition: opacity 0.15s;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2 justify-content-end custom-filter-slot">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </form>
@endif

@push('scripts')
    @include('components.scripts.search-filter')
@endpush