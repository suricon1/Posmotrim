@if ($paginator->hasPages())

    <ul class="pagination justify-content-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{--<li class="disabled">Назад</li>  /page-2.html?page=1  --}}
        @else
            <li><a class="page-link" href="{{ preg_replace($pattern, $replace, $paginator->previousPageUrl()) }}{{$param}}" rel="prev"><i class="fa fa-angle-double-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a class="page-link" href="{{ preg_replace($pattern, $replace, $url) }}{{$param}}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="page-link" href="{{ preg_replace($pattern, $replace, $paginator->nextPageUrl()) }}{{$param}}" rel="next"><i class="fa fa-angle-double-right"></i></a></li>
        @else
            {{--<li class="disabled">Вперед</li>--}}
        @endif
    </ul>
@endif
