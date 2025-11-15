<div class="dataTables_wrapper ">
    <div class="dataTables_info pagination_info" id="" role="status" aria-live="polite">
        @if($paginator->total()!=0)
            <span>{!! __('common.Showing') !!}</span>
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            <span>{!! __('common.to') !!}</span>
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            <span>{!! __('common.of') !!}</span>
            <span class="font-medium">{{ $paginator->total() }}</span>
            <span>{!! __('common.results') !!}</span>
        @else
            <span>{!! __('common.Empty') !!}</span>
        @endif
    </div>
    <div class="dataTables_paginate paging_simple_numbers" id="">

        @if ($paginator->hasPages())
            @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : $this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)

            @if ($paginator->onFirstPage())
                <span class="paginate_button previous"
                      id="lms_table_previous">
                    <i class="ti-arrow-left"></i>
                </span>
            @else
                <button type="button" class="paginate_button previous"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        wire:loading.attr="disabled"
                        id="lms_table_previous">
                    <i class="ti-arrow-left"></i>
                </button>
            @endif

            <span>

               @foreach ($elements as $element)

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <span
                                wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                                <button type="button"
                                                        class=" paginate_button  current">{{ $page }}</button>
                                            </span>
                                @else
                                    <button type="button"
                                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                            class="paginate_button"
                                            aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                                {{ $page }}
                                            </button>
                                @endif
                                    </span>
                        @endforeach
                    @endif
                @endforeach

    </span>
            @if ($paginator->hasMorePages())
                <button type="button"
                        class="paginate_button next" class="page-link"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        wire:loading.attr="disabled"><i
                        class="ti-arrow-right"></i>
                </button>
            @else
                <span
                    class="paginate_button next"><i
                        class="ti-arrow-right"></i>
                </span>
            @endif
        @endif
    </div>
</div>


