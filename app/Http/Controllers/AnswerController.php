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
        // Check if the quiz time has expired (Optional: Uncomment if needed)
        /*
        $quizDuration = Quiz::where('id', $request->quiz_id)->value('duration');
        if (Carbon::now() > Carbon::parse($request->start_time)->addMinute($quizDuration)) {
            return redirect()->back()->with('error', 'Time is Over');
        }
        */

        // Fetch all questions for the quiz
        $db_answers = Question::where('quiz_id', $request->quiz_id)->get();
        $correct = 0;
        $total = 0;

        // Hygiene categories initialization
        $categories = [
            'storage_dovice' => ['total' => 0, 'correct' => 0],
            'transmission_browsing' => ['total' => 0, 'correct' => 0],
            'social_media' => ['total' => 0, 'correct' => 0],
            'authentication' => ['total' => 0, 'correct' => 0],
            'messaging' => ['total' => 0, 'correct' => 0],
        ];

        foreach ($db_answers as $index => $db_answer) {
            $submitted_answer = $request->answer[$index] ?? null;
            $this->evaluateAnswer($db_answer, $submitted_answer, $correct, $total, $categories);
        }

        // Calculate hygiene category scores
        $category_scores = $this->calculateCategoryScores($categories);

        // Store the quiz result
        Result::create([
            'user_id' => session('user_id'),
            'quiz_id' => $request->quiz_id,
            'quiz_score' => $total,
            'achieved_score' => $correct,
            'storage_dovice_score' => $category_scores['storage_dovice'],
            'transmission_browsing_score' => $category_scores['transmission_browsing'],
            'social_media_score' => $category_scores['social_media'],
            'authentication_score' => $category_scores['authentication'],
            'messaging_score' => $category_scores['messaging'],
        ]);

        return redirect()->route('results')->with('success', 'Quiz completed and results published.');
    }

    /**
     * Evaluates the submitted answer and updates scores accordingly.
     */
    private function evaluateAnswer($db_answer, $submitted_answer, &$correct, &$total, &$categories)
    {
        if (is_null($submitted_answer)) return; // Skip if no answer submitted

        $is_correct = match ($db_answer->type) {
            'fill_blank', 'short_answer' => strtolower(trim($submitted_answer)) === strtolower(trim($db_answer->correct_answer)),
            'mcq', 'image', 'true_false' => $submitted_answer == $db_answer->correct_answer,
            default => false,
        };

        if ($is_correct) {
            $correct++;
        }

        $total++;

        // Check and update hygiene category
        if (isset($categories[$db_answer->hygiene])) {
            $categories[$db_answer->hygiene]['total']++;
            if ($is_correct) {
                $categories[$db_answer->hygiene]['correct']++;
            }
        }
    }

    /**
     * Calculates the percentage scores for each hygiene category.
     */
    private function calculateCategoryScores($categories)
    {
        return array_map(fn($data) => $data['total'] > 0 ? ($data['correct'] / $data['total']) * 100 : 0, $categories);
    }
}
