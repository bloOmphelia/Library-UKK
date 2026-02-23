@if(!empty($title))
    <h5 class="fw-semibold mb-1">{{ $title }}</h5>
@endif

@if(!empty($description))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" id="{{ $id ?? Str::slug($title, '-') }}">
                <p class="text-muted">{{ $description }}</p>
            </li>
        </ol>
    </nav>
@endif
