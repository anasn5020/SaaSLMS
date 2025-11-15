<div>
    <style>
        .singleBranch {
            display: flex;
            grid-gap: 5px;
        }

        .branchList tbody th, .branchList tbody td {
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
    <table
        wire:ignore
        id="" class="table  branchList">
        @php
            $level=1;
        @endphp
        <tbody>
        @if(!empty($categories))
            @foreach($categories->where('parent_id',0) as $key=>$category)
                {{--                @include('org::category._single_category',['$category'=>$category,'level'=>1])--}}

                <tr class="{{$level!=1?'collapse':''}} nastable{{$level}}   parentId0  "
                    data-id="{{$category->id}}"
                    data-parent_id="0"
                    {{--        wire:ignore--}}
                    :key="{{$category->id}}"
                    data-level="{{$level}}"
                >
                    <td class="singleBranch" style="padding: 0">
                        @for($i=2;$i<=$level;$i++)
                            <span class="text-white">=</span>
                        @endfor
                        @if(count($category->childs)!=0)
                            <a class="link_value theme_btn small_btn4 btn-header-link collapsed"
                               data-bs-toggle="collapse"
                               href="#collapseBranch{{$category->id}}" role="button"
                               aria-expanded="false"
                               data-level="{{$level}}"
                               data-category_id="{{$category->id}}"
                               data-parent_id="{{$category->parent_id}}"
                               aria-controls="collapseBranch">
                            </a>
                        @else
                            <a href="#">
                                <i class="fas fa-circle" style="    font-size: 8px; "></i>
                            </a>
                        @endif
                        <a href="#" wire:click="categoryFilter('{{$category->id}}')"
                           data-id="{{$category->id}}"
                           data-parent="0"
                           class="activeBranchCode  ">
                            <span>{{$category->name}}</span>
                        </a>


                    </td>
                    <td style="padding-right: 16px!important;">

                        <label class="primary_checkbox  ms-auto d-flex " for="category-{{$category->id}}">
                            <input type="checkbox" id="category-{{$category->id}}" name="category[]"
                                   class=" common-checkbox checkCategory"
                                   data-id="{{$category->id}}"
                            >
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    @push('js')

        <script>
            // $(document).on("click", ".changeOrgStatus", function () {
            //     $.LoadingOverlay("show");
            // });
            //
            // Livewire.hook('element.updated', (el,component) => {
            //     if(component.name=='show-category') {
            //         $.LoadingOverlay("hide");
            //     }
            // })
        </script>

        <script>
            function removeChild(parent_id, ids) {
                let child = $('.category_' + parent_id);
                ids.push(parent_id);

                if (child.length) {
                    $(child).each(function (index) {
                        let id = $(this).data('id');
                        removeChild(id, ids);
                    });
                }
                return ids

            }

            function showPreloader() {
                $.LoadingOverlay("show");
            }

            function hidePreloader() {
                $.LoadingOverlay("hide");
            }

            function loadChildBranch(id, level, item, active) {
                let url = "{{route('org.category-tree-list')}}"
                showPreloader()
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {id: id, level: level, active: active},
                    success: function (data) {
                        item.closest('tr').after(data);

                        hidePreloader();
                    }
                });
            }

            $(document).on('click', '.btn-header-link', function () {
                let item = $(this);
                let category_id = item.data('category_id');
                let level = item.data('level');
                let status = item.hasClass('collapsed');


                if (status) {
                    item.removeClass('collapsed');
                    let itemStatus = item.closest('tr').find('.checkCategory').is(":checked")
                    loadChildBranch(category_id, level, item, itemStatus)
                } else {
                    item.addClass('collapsed');
                    let ids = [];
                    $(removeChild(category_id, ids)).each(function (index, parent_id) {
                        $('.category_' + parent_id).remove();
                    });

                }
            });

            $(document).on("click", ".checkCategory", function () {
                $.LoadingOverlay("show");
                let item = $(this);
                let itemStatus = item.is(":checked")


                let parent_id = item.closest('tr').data('parent_id')
                let parentStatus = $('tr[data-id=' + parent_id + ']').find('.checkCategory').is(":checked");
                console.log(parentStatus, parent_id)
                if (parentStatus) {
                    $.LoadingOverlay("hide");
                    return false;
                }

                item.attr('checked', itemStatus)
                let id = item.data('id')
                if (itemStatus) {
                    item.closest('tr').find('a').addClass('active');
                } else {
                    item.closest('tr').find('a').removeClass('active');
                    item.closest('tr').find('.active').removeClass('active');

                }


                let ids = [];
                let category_id = item.closest('tr').data('id');

                let removeList = removeChild(category_id, ids);
                let uniqueRemoveList = [...new Set(removeList)]

                $(uniqueRemoveList).each(function (index, parent_id) {
                    let link = $('.category_' + parent_id).find('a');
                    let input = $('.category_' + parent_id).find('.checkCategory');

                    $(link).each(function (index) {
                        let $this = $(this);
                        if (itemStatus) {
                            $this.addClass('active');

                        } else {
                            $this.removeClass('active');
                        }
                    });
                    if (itemStatus) {
                        input.attr('checked', true)
                    } else {
                        input.attr('checked', false)
                    }

                });

                // $(removeChild(category_id, ids)).each(function (index, parent_id) {
                //     let link = $('.category_' + parent_id).find('a');
                //     let input = $('.category_' + parent_id).find('.checkCategory');
                //
                //     if (itemStatus) {
                //         link.addClass('active');
                //         input.attr('checked', true)
                //     } else {
                //         link.removeClass('active');
                //         input.attr('checked', false)
                //     }
                // });

                @this.
                categoryFilter(id)
            });
            let loaded = 0
            window.livewire.on('checkCategory', message => {
                setTimeout(function () {
                    $.LoadingOverlay("hide");
                }, 2000);

            })
            // window.livewire.on('addCategoryFilter', message => {
            //     $.LoadingOverlay("hide");
            //
            // })
        </script>

    @endpush
</div>
