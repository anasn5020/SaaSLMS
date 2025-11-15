<div>
    <style>
        .list-group-item2 {
            padding: 6px;
        }

        .list-group-item2 label{
            margin: 0;
        }
        .list-group-item2 .primary_checkbox2 input:checked ~ .checkmark {
            background: transparent;
        }
        .list-group-item2 .primary_checkbox2.error_ans input:checked ~ .checkmark {
            background: transparent;
        }

        .primary_checkbox .checkmark:after,
        .primary_checkbox2 .checkmark:after{
            border-color: #D1D1D1 !important;
            background: transparent;
        }

        .primary_checkbox input:checked ~ .checkmark::before,
        .primary_checkbox2 input:checked ~ .checkmark::before{
            background: #16CE8C;
        }
        .primary_checkbox.error_ans input:checked ~ .checkmark::before,
        .primary_checkbox2.error_ans input:checked ~ .checkmark::before{
            background: #FF4545;
            content: "";
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            right: auto;
            z-index: 86;
        }
        .primary_checkbox2 input:checked ~ .label_name {
            color: #16CE8C;
        }

        .primary_checkbox2.error_ans input:checked ~ .label_name {
            color: #FF4545;
        }

        .primary_checkbox input:checked ~ .checkmark:after,
        .primary_checkbox2 input:checked ~ .checkmark:after{
            border-color: #16CE8C !important;
        }

        .primary_checkbox.error_ans input:checked ~ .checkmark:after,
        .primary_checkbox2.error_ans input:checked ~ .checkmark:after{
            border-color: #FF4545!important;
        }

        .primary_checkbox2 svg{
            width: 24px;
            height: 24px;
            margin-left: 10px;
        }

        html[dir="rtl"] .primary_checkbox2 svg{
            margin-right: 10px;
            margin-left: 0;
        }
    </style>

    <div class="question_list d-none">

        @foreach($quiz->assign as $key=>$assign)
            @php
                $qus= $assign->questionBank;
            @endphp
            <div class="card mb-4" id="question{{$qus->id}}">
                <div class="card-header">
                    <b>{{__('quiz.Question')}} {{++$key}}</b>
                </div>
                <div class="card-body">
                    <p class="card-text">{!! $qus->question !!}</p>
                    <a href="#" class="btn theme_btn_mini hide_show_btn"
                       data-id="{{$qus->id}}" data-type="check">{{__('quiz.Check')}}</a>
                    <a href="#" class="btn theme_btn_mini hide_show_btn"
                       data-id="{{$qus->id}}" data-type="hide">{{__('quiz.Hide Answer')}}</a>

                    <div class="answer{{$qus->id}} d-none list mt-4">
                        <ul class="">
                            @foreach($qus->questionMuInSerial as $option)
                                <li class="list-group-item2 list-option" id="list_option{{$option->id}}">
                                    <label
                                        class="primary_checkbox2 d-flex ">
                                        <input id="option{{$option->id}}"
                                               disabled
                                               type="checkbox">
                                        <span class="checkmark mr_10"></span>
                                        <span class="label_name">{{$option->title}}
                                            <span class="text-danger d-none">
                                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18 34C26.8366 34 34 26.8366 34 18C34 9.16344 26.8366 2 18 2C9.16344 2 2 9.16344 2 18C2 26.8366 9.16344 34 18 34Z" fill="#FF4545" stroke="#FF4545" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M23.5139 12.2353L23.6485 12.3515C24.0746 12.7775 24.1133 13.4442 23.7647 13.9139L23.6485 14.0485L19.6976 18L23.6485 21.9515C24.0746 22.3775 24.1133 23.0442 23.7647 23.5139L23.6485 23.6485C23.2226 24.0746 22.5559 24.1133 22.0861 23.7647L21.9515 23.6485L18 19.6976L14.0485 23.6485C13.6225 24.0746 12.9558 24.1133 12.4861 23.7647L12.3515 23.6485C11.9254 23.2226 11.8867 22.5559 12.2353 22.0861L12.3515 21.9515L16.3024 18L12.3515 14.0485C11.9254 13.6225 11.8867 12.9558 12.2353 12.4861L12.3515 12.3515C12.7775 11.9254 13.4442 11.8867 13.9139 12.2353L14.0485 12.3515L18 16.3024L21.9515 12.3515C22.3775 11.9254 23.0442 11.8867 23.5139 12.2353Z" fill="white"/>
                                                </svg>
                                            </span>
                                            <span class="text-success d-none">
                                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18 34C26.8366 34 34 26.8366 34 18C34 9.16344 26.8366 2 18 2C9.16344 2 2 9.16344 2 18C2 26.8366 9.16344 34 18 34Z" fill="#16CE8C" stroke="#16CE8C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M11.6016 19.6001L16.2561 24.4001C18.4464 18.1084 20.2704 15.3476 24.4016 11.6001" fill="#16CE8C"/>
                                                    <path d="M11.6016 19.6001L16.2561 24.4001C18.4464 18.1084 20.2704 15.3476 24.4016 11.6001" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card-footer answer{{$qus->id}} d-none ">
                    <b>
                        {{__('quiz.Explanation')}}
                    </b>
                </div>
                <div class="card-body answer{{$qus->id}} d-none">
                    <p class="card-text">
                        {!! $qus->explanation !!}
                    </p>

                </div>
            </div>
        @endforeach

    </div>


    @include(theme('partials._quiz_exp_script'))
</div>
