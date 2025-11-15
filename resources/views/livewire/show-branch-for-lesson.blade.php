<div>
    <div class="primary_input mb-25">

        <input class="primary_input_field" name="name" placeholder="Filter" type="text" id="addName" value="">
    </div>
    <table id="" class="table  branchList">
        <tbody>
        @if(!empty($branches))
            @foreach($branches->where('parent_id',0) as $key=>$branch)
                @include('org::lesson._single_branch_with_file',['branch'=>$branch,'level'=>1])
            @endforeach
        @endif
        </tbody>
    </table>

    @push('js')
        <script>
            $(document).on("click", ".activeBranchCode", function () {
                var type = $(this).data('type');
                var input = $('#branchSelectType');
                input.val(type);
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).addClass('active');
                }

                // branchSelectType
            });
        </script>
    @endpush
</div>
