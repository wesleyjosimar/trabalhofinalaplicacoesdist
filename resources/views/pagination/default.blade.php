@if ($paginator->hasPages())
    <nav>
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="disabled" style="padding: 0.5rem 1rem; border: 1px solid #ddd; border-radius: 4px; color: #999;">Anterior</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="padding: 0.5rem 1rem; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333;">Anterior</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span style="padding: 0.5rem 1rem; border: 1px solid #ddd; border-radius: 4px; color: #999;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="active" style="padding: 0.5rem 1rem; border: 1px solid #006600; border-radius: 4px; background-color: #006600; color: white;">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="padding: 0.5rem 1rem; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333;">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="padding: 0.5rem 1rem; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333;">Próxima</a>
            @else
                <span class="disabled" style="padding: 0.5rem 1rem; border: 1px solid #ddd; border-radius: 4px; color: #999;">Próxima</span>
            @endif
        </div>
    </nav>
@endif

