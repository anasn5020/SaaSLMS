<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionAnswerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $question, $user;


    public function __construct($question, $user = null)
    {
        config()->set('broadcasting.default', 'pusher');

        $this->question = $question;
        $this->user = $user;
    }


//    public function broadcastOn(): string
//    {
//        return 'question-answer-channel';
//    }
    public function broadcastOn()
    {
        return ['question-answer-channel'];
    }

    public function broadcastAs()
    {
        return 'new-question-answer' . $this->question['id'] ?? '';
    }

}
