<ul class="quiz_select">
    @foreach($options as $option)

        <li>
            <label
                class="primary_bulet_checkbox d-flex">
                <input class="quizAns"
                       name="ans[{{$option->question_bank_id}}][]"
                       type="checkbox"
                       value="{{$option->id}}">

                <span
                    class="checkmark mr_10"></span>
                <span
                    class="label_name">{{$option->title}} </span>
            </label>
        </li>
    @endforeach

</ul>
