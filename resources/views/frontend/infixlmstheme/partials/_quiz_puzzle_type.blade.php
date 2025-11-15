@php
    $puzzleQus = $options->where('type',1);
    $puzzleAns = $options->where('type',0);
@endphp

<style>
    .question-box, .answer-box {
        border: 1px solid #e0e0e0;
        padding: 20px;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .question-box, .answer-box:hover {
        background-color: #f9f9f9;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .answer-container{
        min-height: 200px!important;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .answer-container {
        min-height: 60px;
        padding: 15px;
        border: 2px dashed #d1d1d1;
        background-color: #fafafa;
        margin-bottom: 10px;
        border-radius: 8px;
    }

    .dropped-answer {
        border: 1px solid;
        border-color: #d1d1d1;
        background: white;
        padding: 10px;
        border-radius: 8px;
        display: inline-block;
        height: fit-content;
        display: inline-flex;
        align-items: center;
        font-size: 16px;
    }

    .dropped-answer button.remove-answer {
        color: black!important;
        border: none;
        color: white;
        padding: 5px 10px;
        margin-left: 15px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s ease;
        background: transparent;
        line-height: 1;
    }
    /*
        .dropped-answer button.remove-answer:hover {
            background-color: #ff1c1c;
        } */

    .ui-draggable-dragging {
        opacity: 0.7;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background-color: #ffffff;
    }

    .ui-droppable-active {
        background-color: #f0f9ff;
    }

    .answer-box .handle {
        height: 100%;
    }

    .answer-text-content {
        width: calc(100% - 50px);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

</style>

<div class="puzzleQuestionBox">
    <div class="quiz_select puzzle-options" id="puzzleQuestions">
        <div class="row row-gap-24">

            @foreach($puzzleQus as $option)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class='row m-0 question-box mt-25' data-question-id="{{$option->id}}"
                         data-bank="{{$qusBank->id}}">


                        <div class='answer-container'>
                            <!-- This is where answers will be dropped -->
                        </div>

                        <div class='col-lg-12 text-center'>
                            <div class='input-effect'>
                                {{$option->title}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="quiz_select puzzle-options" id="puzzleAnswers">
        <div class="row row-gap-24">

            @foreach($puzzleAns as $option)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class='d-flex gap-3 m-0 answer-box mt-25' data-answer-id="{{$option->id}}"
                         data-bank="{{$qusBank->id}}">
                        <div class='flex-grow-1'>
                            <div class='input-effect answer-input'>
                                {{$option->title}}
                            </div>
                        </div>
                        <div class='mt-15'>
                            <span class='drag-handle handle' style='cursor: move;'>&#9776;</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <input type="hidden" id="puzzle_answer_{{$qusBank->id}}">
</div>

