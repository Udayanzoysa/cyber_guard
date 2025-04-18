<?php

namespace App\Http\Controllers;

use App\Models\ExamCandidate;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index()
    {
        if (session('user_role') == 'admin') {
            return view('admin.quiz-list')->with('quiz_list', Quiz::all());
        }
        return view('user.quiz-list')->with('quiz_list', Quiz::join('questions', 'quizzes.id', '=', 'questions.quiz_id')->distinct('quizzes.id')
            ->select('quizzes.id as quiz_id', 'quizzes.*')
            ->get());
    }

    public function addQuiz()
    {
        return view('admin.add-quiz');
    }

    public function storeQuiz(Request $request)
    {
        if (Quiz::create([
            'title' => $request->title,
            'from_time' => $request->from_time,
            'to_time' => $request->to_time,
            'duration' => $request->duration,
            'base_quiz' => true
        ])) {
            return redirect()->back()->with('success', 'Quiz: ' . $request->title . ' added successfully!');
        }
        return redirect()->back()->with('error', 'Quiz: ' . $request->title . ' was not added. Something wrong!');
    }

    public function joinQuiz($id)
    {

        // if (count(ExamCandidate::where('quiz_id',$id)->where('user_id','=',session('user_id'))->get())>0){
        //     return redirect()->back()->with('error','You already participated this quiz');
        // }

        // if (time()>=strtotime(Quiz::where('id',$id)->value('to_time'))){
        //     return redirect()->back()->with('error','Quiz is no longer available');
        // }
        // if (time()<strtotime(Quiz::where('id',$id)->value('from_time'))){
        //     return redirect()->back()->with('error','Quiz is not available now. Wait for its availability ');
        // }

        // if (session('user_role')=='user'&&count(Result::where('user_id',session('user_id'))->get())>0){
        //     return redirect()->back()->with('error','You already participated this quiz');
        // }

        ExamCandidate::create([
            'user_id' => session('user_id'),
            'quiz_id' => $id
        ]);

        return view('user.give-quiz')->with('quiz', Quiz::where('id', $id)->first())
            ->with('questions', Question::where('quiz_id', $id)->get())
            ->with('start_time', Carbon::now());
    }
    public function baseQize($id = 1)
    {
        session([
            'exam_candidate' => [
                'user_id' => rand(100000, 999999),
                'quiz_id' => $id
            ]
        ]);

        return view('user.give-base-quiz')->with('quiz', Quiz::where('id', $id)->first())
            ->with('questions', Question::where('quiz_id', $id)->get())
            ->with('start_time', Carbon::now());
    }

    public function showBaseQuestion(Quiz $quiz, $index = 0)
    {
        $questions = $quiz->questions()->get(); // Ensure it retrieves questions

        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No questions found for this quiz.');
        }

        if ($index < 0 || $index >= count($questions)) {
            return redirect()->route('quizbase.page', ['quiz' => $quiz->id, 'index' => 0]);
        }

        return view('user.give-base-quiz', [
            'quiz' => $quiz,
            'questions' => $questions,
            'index' => $index
        ]);
    }
    public function showQuestion(Quiz $quiz, $index = 0)
    {
        $questions = $quiz->questions()->get(); // Ensure it retrieves questions

        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No questions found for this quiz.');
        }

        if ($index < 0 || $index >= count($questions)) {
            return redirect()->route('quiz.page', ['quiz' => $quiz->id, 'index' => 0]);
        }

        return view('user.give-quiz', [
            'quiz' => $quiz,
            'questions' => $questions,
            'index' => $index
        ]);
    }
}
