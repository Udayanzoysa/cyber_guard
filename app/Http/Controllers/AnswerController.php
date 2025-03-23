<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        // Check if the quiz time is over
        // if (Carbon::now() > Carbon::parse($request->start_time)->addMinute(Quiz::where('id', $request->quiz_id)->value('duration'))) {
        //     return redirect()->back()->with('error', 'Time is Over');
        // }

        $db_answers = Question::where('quiz_id', $request->quiz_id)->get();
        $correct = 0;
        $total = 0;

        foreach ($db_answers as $index => $db_answer) {
            if (isset($request->answer[$index])) {
                $submitted_answer = $request->answer[$index];

                if ($db_answer->type == 'fill_blank' || $db_answer->type == 'short_answer') {
                    if (strtolower($submitted_answer) === strtolower($db_answer->correct_answer)) {
                        $correct++;
                    }
                } elseif ($db_answer->type == 'mcq' || $db_answer->type == 'image') {
                    if ($submitted_answer == $db_answer->correct_answer) {
                        $correct++;
                    }
                } elseif ($db_answer->type == 'true_false') {
                    if ($submitted_answer == $db_answer->correct_answer) {
                        $correct++;
                    }
                }

                $total++;
            }
        }

        // Save the result
        Result::create([
            'user_id' => session('user_id'),
            'quiz_id' => $request->quiz_id,
            'quiz_score' => $total,
            'achieved_score' => $correct
        ]);

        return redirect()->route('results')->with('success', 'Quiz done and result published');
    }
}
