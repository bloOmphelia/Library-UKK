@props([
    'title' => '',
    'description' => '',
    'category' => 'Aktivitas',
])

<div class="card welcome-card">
    <div class="card-body p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <p class="text-muted mb-1" style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    {{ $category }}
                </p>
                @if(!empty($title))
                    <h2 class="mb-2">{{ $title }}</h2>
                @endif
                @if(!empty($description))
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                            <li class="breadcrumb-item active" aria-current="page">
                                <span class="text-muted">{!! $description !!}</span>
                            </li>
                        </ol>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .welcome-card {
        background-color: #e5e0d8 !important; /* var(--primary-bg) */
        border-radius: 34px !important;
        border: none !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .welcome-card h2 {
        font-family: 'Fraunces', serif;
        font-weight: 1000;
        font-size: 32px;
        color: #1e1e1e; /* var(--dark) */
    }

    /* Menghilangkan bullet/separator default bootstrap breadcrumb jika di dalam banner */
    .welcome-card .breadcrumb-item + .breadcrumb-item::before {
        content: ">"; 
        color: #777;
    }
</style>