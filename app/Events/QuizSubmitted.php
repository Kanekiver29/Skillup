<?php

namespace App\Events;

use App\Models\UserQuizAttempt;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attempt;

    public function __construct(UserQuizAttempt $attempt)
    {
        $this->attempt = $attempt;
    }

    public function broadcastOn()
    {
        return new Channel('quizzes');
    }

    public function broadcastWith()
    {
        return [
            'attempt_id' => $this->attempt->id,
            'quiz_id' => $this->attempt->quiz_id,
            'user_id' => $this->attempt->user_id,
            'score_percentage' => $this->attempt->score_percentage,
            'passed' => (bool) $this->attempt->passed,
            'completed_at' => $this->attempt->completed_at?->toDateTimeString(),
        ];
    }
}
