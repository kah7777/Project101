<?php

namespace App\Observers;

use App\Models\Question;
use App\Models\Test;

class QuestionObserver
{
    /**
     * Handle the Question "created" event.
     */
    public function created(Question $question): void
    {
        if($question->test_id==Test::getBeginnerTestId()) {
            $this->updateBeginnerTestThreshold();
        }
    }

    /**
     * Handle the Question "updated" event.
     */
    public function updated(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "deleted" event.
     */
    public function deleted(Question $question): void
    {
        if($question->test_id==Test::getBeginnerTestId()) {
            $this->updateBeginnerTestThreshold();
        }
    }

    /**
     * Handle the Question "restored" event.
     */
    public function restored(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "force deleted" event.
     */
    public function forceDeleted(Question $question): void
    {
        //
    }

    private function updateBeginnerTestThreshold()
    {
        $test = Test::beginnerTest()->first();
        $test->update([
            'threshold' => $test->questions()->count()
        ]);
    }
}
