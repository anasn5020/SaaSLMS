<div>
    <style>
        .branch_no_child_icon {
            margin-top: 6px !important;
        }
    </style>
    <table id=""
           wire:ignore
           class="table  branchList ">
        <tbody>
        @php
            $level=1;
        @endphp
        @if(!empty($branches))
            @foreach($branches->where('parent_id',0) as $key=>$branch)
                {{--                @include('orginstructorpolicy::_single_branch',['branch'=>$branch,'level'=>1])--}}

                <tr class="{{$level!=1?'collapse':''}} nastable{{$level}}   parentId0  "
                    data-id="{{$branch->id}}"
                    {{--        wire:ignore--}}
                    :key="{{$branch->id}}"
                    data-level="{{$level}}"
                >
                    <td class="singleBranch" style="padding: 0;    text-align: left;">
                        @for($i=2;$i<=$level;$i++)
                            <span class="text-white">=</span>
                        @endfor
                        @if(count($branch->childs)!=0)
                            <a class="link_value theme_btn small_btn4 btn-header-link collapsed"
                               data-bs-toggle="collapse"
                               href="#collapseBranch{{$branch->id}}" role="button"
                               aria-expanded="false"
                               data-level="{{$level}}"
                               data-branch_id="{{$branch->id}}"
                               aria-controls="collapseBranch">
                            </a>
                        @else
                            <a href="#">
                                <i class="fas fa-circle" style="    font-size: 8px; "></i>
                            </a>
                        @endif
                        <a href="#"
                           data-id="{{$branch->id}}"
                           data-parent="0"
                           class="activeBranchCode  {{in_array($branch->code,$codes)?'active':''}} ">
                            <span>{{$branch->group}}</span>
                        </a>


                    </td>
                    <td class="" style="padding: 0">

                        <label class="primary_checkbox d-flex " for="branch-{{$branch->id}}">
                            <input type="checkbox" id="branch-{{$branch->id}}" name="branch[]"
                                   class=" common-checkbox checkBranch"
                                   value="{{$branch->id}}"
                                   {{in_array($branch->code,$codes)?'checked':''}}
                                   data-code="{{$branch->code}}"
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

            //            $(document).on("click", ".btn-header-link", function () {
            //                var id = $(this).data('branch_id');
            //                var parent_id = $(this).data('parent_id');
            //                var childs = $('.parentId' + id);
            //                var status = false;
            //                if ($(this).hasClass('collapsed')) {
            //                    status = true;
            //                }
            //                if (status) {
            //                    checkChildActive(childs);
            //                }
            //
            //
            //            });
            //
            //
            //            function checkChildActive(childs) {
            //                childs.each(function (i, obj) {
            //                    var parent = $(this);
            //                    parent.removeClass('show');
            //
            //
            //                    var id = parent.data('id');
            //                    var childs = $('.parentId' + id);
            //                    if (childs.length) {
            //                        checkChildActive(childs)
            //                    }
            //                });
            //            }
            //
        </script>

        <script>


            function removeChild(parent_id, ids) {
                let child = $('.branch_' + parent_id);
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
                let url = "{{route('org.branch-tree-list')}}"
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
                let branch_id = item.data('branch_id');
                let level = item.data('level');
                let status = item.hasClass('collapsed');


                if (status) {
                    item.removeClass('collapsed');
                    let itemStatus = item.closest('tr').find('.checkBranch').is(":checked")
                    loadChildBranch(branch_id, level, item, itemStatus)
                } else {
                    item.addClass('collapsed');
                    let ids = [];
                    $(removeChild(branch_id, ids)).each(function (index, parent_id) {
                        $('.branch_' + parent_id).remove();
                    });

                }
            });

            $(document).on("click", ".checkBranch", function () {
                // $.LoadingOverlay("show");
                let item = $(this);
                let itemStatus = item.is(":checked")
                item.attr('checked', itemStatus)
                let code = item.data('code')
                // console.log(item, itemStatus)
                if (itemStatus) {
                    item.closest('tr').find('a').addClass('active');
                } else {
                    item.closest('tr').find('a').removeClass('active');
                    item.closest('tr').find('.active').removeClass('active');

                }
                let ids = [];
                let branch_id = item.closest('tr').data('id');

                $(removeChild(branch_id, ids)).each(function (index, parent_id) {
                    let link = $('.branch_' + parent_id).find('a');
                    let input = $('.branch_' + parent_id).find('.checkBranch');
                    console.log(link)
                    if (itemStatus) {
                        link.addClass('active');
                        input.attr('checked', true)
                    } else {
                        link.removeClass('active');
                        input.attr('checked', false)
                    }
                });

                @this.
                branchFilter(code)
            });

            // window.livewire.on('addBranchFilter', message => {
            //     $.LoadingOverlay("hide");
            //
            // })
        </script>
    @endpush
</div>
