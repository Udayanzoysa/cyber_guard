<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        if (session('user_role') == 'admin') {
            $results = Result::join('quizzes', 'results.quiz_id', '=', 'quizzes.id')
                ->join('users', 'results.user_id', '=', 'users.id')
                ->select('results.id as resultid', 'results.*', 'quizzes.title', 'quizzes.duration', 'quizzes.from_time', 'quizzes.to_time', 'users.username')
                ->get();
        } else {
            $results = Result::join('quizzes', 'results.quiz_id', '=', 'quizzes.id')
                ->where('results.user_id', session('user_id'))
                ->select('results.id as resultid', 'results.*', 'quizzes.title', 'quizzes.duration', 'quizzes.from_time', 'quizzes.to_time')
                ->get();
        }

        return view('user.result-page', compact('results'));
    }
    public function resultDetails($id)
    {
        if (session('user_role') == 'admin') {
            $result = Result::join('quizzes', 'results.quiz_id', '=', 'quizzes.id')
                ->join('users', 'results.user_id', '=', 'users.id')
                ->where('results.id', $id)
                ->first();

            return view('user.result-detail', compact('result'));
        }
        $result = Result::join('quizzes', 'results.quiz_id', '=', 'quizzes.id')
            ->where('results.id', $id)
            ->where('results.user_id', session('user_id'))
            ->select('results.*', 'quizzes.title', 'quizzes.duration', 'quizzes.from_time', 'quizzes.to_time')
            ->first();

        return view('user.result-detail', compact('result'));
    }
    public function baseResultDetails()
    {
        $result = session('quiz_result');

        if ($result) {
            return view('user.base-result-detail', ['result' => $result]);
        }
    }
}
