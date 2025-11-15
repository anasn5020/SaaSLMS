@foreach($lesson_questions as $qna)
    @include(theme('partials._single_qna'),['qna'=>$qna])
@endforeach
