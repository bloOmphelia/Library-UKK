@props(['paginator'])

@if ($paginator->hasPages())
    <style>
        .custom-pagination {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
            align-items: center;
        }

        .custom-pagination .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.5); /* Glassmorphism */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            color: #40487A;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .custom-pagination .page-item.active .page-link {
            background: #40487A !important;
            color: white !important;
            border-color: #40487A;
            box-shadow: 0 4px 12px rgba(64, 72, 122, 0.2);
        }

        .custom-pagination .page-item:not(.active):not(.disabled) .page-link:hover {
            background: rgba(172, 127, 246, 0.1);
            color: #AC7FF6;
            transform: translateY(-2px);
        }

        .custom-pagination .page-item.disabled .page-link {
            opacity: 0.5;
            background: rgba(255, 255, 255, 0.2);
            cursor: not-allowed;
        }

        .custom-pagination .dots .page-link {
            background: transparent;
            border: none;
            backdrop-filter: none;
        }
    </style>

    <ul class="custom-pagination justify-content-center mt-4">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="m9.55 12l7.35 7.35q.375.375.363.875t-.388.875t-.875.375t-.875-.375l-7.7-7.675q-.3-.3-.45-.675t-.15-.75t.15-.75t.45-.675l7.7-7.7q.375-.375.888-.363t.887.388t.375.875t-.375.875z"/></svg></span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="m9.55 12l7.35 7.35q.375.375.363.875t-.388.875t-.875.375t-.875-.375l-7.7-7.675q-.3-.3-.45-.675t-.15-.75t.15-.75t.45-.675l7.7-7.7q.375-.375.888-.363t.887.388t.375.875t-.375.875z"/></svg></a>
            </li>
        @endif

        @if ($paginator->lastPage() > 5 && $paginator->currentPage() > 3)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            <li class="page-item disabled dots"><span class="page-link">...</span></li>
        @endif

        @for ($i = max(1, $paginator->currentPage() - 2); $i <= min($paginator->lastPage(), $paginator->currentPage() + 2); $i++)
            <li class="page-item {{ $paginator->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($paginator->lastPage() > 5 && $paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item disabled dots"><span class="page-link">...</span></li>
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="m14.475 12l-7.35-7.35q-.375-.375-.363-.888t.388-.887t.888-.375t.887.375l7.675 7.7q.3.3.45.675t.15.75t-.15.75t-.45.675l-7.7 7.7q-.375.375-.875.363T7.15 21.1t-.375-.888t.375-.887z"/></svg></a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="m14.475 12l-7.35-7.35q-.375-.375-.363-.888t.388-.887t.888-.375t.887.375l7.675 7.7q.3.3.45.675t.15.75t-.15.75t-.45.675l-7.7 7.7q-.375.375-.875.363T7.15 21.1t-.375-.888t.375-.887z"/></svg></span>
            </li>
        @endif
    </ul>
@endif