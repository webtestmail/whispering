<style>
    .custom-pagination button {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    outline: none;
}

.page-btn.circle.active {
    background-color: #5e66c1; /* Your purple color */
    color: white;
}
</style>
@if ($paginator->hasPages())
    <div class="custom-pagination d-flex align-items-center justify-content-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-btn circle purple disabled"><i class="bi bi-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" wire:click="previousPage" class="page-btn circle purple"><i class="bi bi-chevron-left"></i></a>
        @endif

        {{-- Compact Pagination Elements --}}
        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();

            // Keep long paginations compact: first, current window, last.
            $windowStart = max(1, $currentPage - 1);
            $windowEnd = min($lastPage, $currentPage + 1);

            if ($currentPage <= 2) {
                $windowStart = 1;
                $windowEnd = min($lastPage, 2);
            }

            if ($currentPage >= $lastPage - 1) {
                $windowStart = max(1, $lastPage - 1);
                $windowEnd = $lastPage;
            }

            $pagesToShow = [1];

            for ($page = $windowStart; $page <= $windowEnd; $page++) {
                $pagesToShow[] = $page;
            }

            $pagesToShow[] = $lastPage;
            $pagesToShow = array_values(array_unique($pagesToShow));

            $previousPage = null;
        @endphp

        @foreach ($pagesToShow as $page)
            @if (!is_null($previousPage) && ($page - $previousPage) > 1)
                <span class="page-dots">...</span>
            @endif

            @if ($page == $currentPage)
                <a href="#" class="page-btn circle active">{{ sprintf('%02d', $page) }}</a>
            @else
                <a href="{{ $paginator->url($page) }}" class="page-btn circle">{{ sprintf('%02d', $page) }}</a>
            @endif

            @php $previousPage = $page; @endphp
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn circle purple"><i class="bi bi-chevron-right"></i></a>
        @else
            <span class="page-btn circle purple disabled"><i class="bi bi-chevron-right"></i></span>
        @endif
    </div>
@endif