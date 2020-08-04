@if ($paginator->hasPages())
    <div class="row">
        <div class="col">
            <div class="pagination">
                <ul>
                    @if ($paginator->onFirstPage())
                        <li class="disabled"><a>&lt;</a></li>
                    @else
                        <li><a href="{{ $paginator->previousPageUrl() }}">&lt;</a></li>
                    @endif

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
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li><a href="{{ $paginator->nextPageUrl() }}">&gt;</a></li>
                    @else
                        <li><a class="disabled">&gt;</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif