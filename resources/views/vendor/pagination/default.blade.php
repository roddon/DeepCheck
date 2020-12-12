@if ($paginator->hasPages())

<ul class="pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <li class="paginate_button previous disabled" aria-label="@lang('pagination.previous')">
        <a>Previous</a>
    </li>
    @else
    <li class="paginate_button previous">
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
    </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <li class="disabled paginate_button" aria-disabled="true"><a>{{ $element }}</a></li>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="paginate_button active" aria-current="page"><a>{{ $page }}</a></li>
    @else
    <li class="paginate_button"><a href="{{ $url }}">{{ $page }}</a></li>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <li class="paginate_button next">
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
    </li>
    @else
    <li class="disabled paginate_button next" aria-disabled="true" aria-label="@lang('pagination.next')">
        <a aria-hidden="true">Next</a>
    </li>
    @endif
</ul>

@endif