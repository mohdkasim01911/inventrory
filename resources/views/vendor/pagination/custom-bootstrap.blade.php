<style>
    .pagination .page-link {
    border-radius: 6px !important;
    padding: 6px 14px;
    color: #6c757d;
}

.pagination .page-item.active .page-link {
    background-color: #3b5bfd;
    border-color: #3b5bfd;
    color: #fff;
    font-weight: 600;
}

.pagination .page-item.disabled .page-link {
    color: #adb5bd;
}

</style>

@if ($paginator->total() > 0) {{-- Always show pagination if there is any data --}}
<div class="d-flex justify-content-between align-items-center mt-4">

    {{-- Left info --}}
    <div class="text-muted small">
        Showing
        {{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }}
        to
        {{ min($paginator->currentPage() * $paginator->perPage(), $paginator->total()) }}
        of {{ $paginator->total() }} entries
    </div>

    {{-- Pagination --}}
    <nav>
        <ul class="pagination pagination-sm mb-0">

            {{-- Previous --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
            </li>

            {{-- Page numbers (always show at least page 1) --}}
            @php
                $start = max(1, $paginator->currentPage() - 1);
                $end = max(1, min($paginator->lastPage(), $paginator->currentPage() + 1));
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($page) }}">
                        {{ $page }}
                    </a>
                </li>
            @endfor

            {{-- Next --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
            </li>

        </ul>
    </nav>
</div>
@endif


