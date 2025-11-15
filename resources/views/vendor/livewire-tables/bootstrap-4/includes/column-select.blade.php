@if ($columnSelect)
    <style>
        #columnSelect{
            color: #415094;
        }
    </style>
    <script src="{{asset('public/js/alpine.min.js')}}"></script>
    <div class="mb-3 mb-md-0 pl-0 pl-md-2"  >
        <div
            x-data="{ open: false }"
            x-on:keydown.escape.stop="open = false"
            x-on:mousedown.away="open = false"
            class="dropdown d-block d-md-inline"
        >
            <button
                x-on:click="open = !open"
                class="btn dropdown-toggle d-block w-100 d-md-inline"
                type="button"
                id="columnSelect"
                aria-haspopup="true"
                style="margin-top: 5px;"
                x-bind:aria-expanded="open"
            >
               <span class="fa fa-columns"></span>
            </button>

            <div
                class="dropdown-menu dropdown-menu-right w-100 mt-0 mt-md-3"
                x-bind:class="{'show' : open}"
                aria-labelledby="columnSelect"
            >
                @foreach($columns as $column)
                    @if ($column->isVisible() && $column->isSelectable())
                        <div wire:key="columnSelect-{{ $loop->index }} " class="p-1 text-nowrap">
                            <label class="primary_checkbox d-flex  px-2 {{ $loop->last ? 'mb-0' : 'mb-1' }}">
                                <input
                                    wire:model="columnSelectEnabled"
                                    wire:target="columnSelectEnabled"
                                    wire:loading.attr="disabled"
                                    type="checkbox"
                                    value="{{ $column->column() }}"
                                    class="common-checkbox"
                                />
                                <span class="checkmark"></span>
                                <span class="ml-2">{{ $column->text() }}</span>
                            </label>




                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
