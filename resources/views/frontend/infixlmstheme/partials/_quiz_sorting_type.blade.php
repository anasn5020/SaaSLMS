
<style>
    .single_sorting_quiz_option:not(:last-child) {
        margin-bottom: 20px;
    }

    .single_sorting_quiz_option {
        align-items: center;
    }

    .single_sorting_quiz_option .handle {
        background: #f1f1f1;
        height: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        border: 1px solid #D1D1D1;
        border-right: 0;
    }
    html[dir="rtl"] .single_sorting_quiz_option .handle {
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        border: 1px solid #D1D1D1;
        border-left: 0;
        border-right: 1px solid #d1d1d1;
    }

    .single_sorting_quiz_option .sorting_ans{
        height: 50px;
        width: 100%;
        border-radius: 0;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        border: 1px solid #D1D1D1;
        padding: 10px 10px;

    }
    html[dir="rtl"] .single_sorting_quiz_option .sorting_ans{
        border-radius: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

</style>

<ul class="quiz_select sorting-options" data-question-id="{{$qusBank->id}}">
    @foreach($options as $option)
        <div class='d-flex single_sorting_quiz_option mt-25'>
            <div class='mt-15'>
                <span class='drag-handle handle' style='cursor: move;'>&#9776;</span>
            </div>
            <div class='flex-grow-1'>
                <div class='input-effect'>
                    <input class='primary_input_field sorting_ans' type='text'
                           readonly
                           data-id="{{$option->id}}"
                           name='ans[{{$option->question_bank_id}}][]' autocomplete='off' required
                           value="{{$option->title}}">
                    <span class='focus-border'></span>
                </div>
            </div>
        </div>
    @endforeach
</ul>
<input type="hidden" name="" id="sorting_has_answer_{{$qusBank->id}}" value="1">
