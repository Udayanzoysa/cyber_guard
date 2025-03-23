<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function addQuestion($id)
    {
        return view('admin.add-questions')->with('quiz_list', Quiz::where('id', $id)->first())
            ->with('questions', Question::where('quiz_id', $id)->get())
            ->with('quiz_id', $id);
    }

    // public function storeQuestion(Request $request){
    //     if (Question::create([
    //         'quiz_id' => $request->quiz_id,
    //         'question' => $request->question,
    //         'type' => $request->type,
    //         'options' => json_encode($request->options),
    //         'correct_answer' => isset($_POST['correct_answer']) ? $_POST['correct_answer'] : null,
    //     ])){
    //         return redirect()->back()->with('success','Question added successfully!');
    //     }
    //     return redirect()->back()->with('error','Something wrong!');
    // }

    public function storeQuestion(Request $request)
    {
        $imagePaths = [];

        // Handle image uploads and store the image paths
        foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $image = $request->file($imageField);
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $imagePaths[] = 'storage/images/' . $imageName; // Add the image path to the options array
            }
        }

        $options = $request->options;

        $answer = $request->correct_answer;
        if ($request->type == 'image') {
            // If image paths are available, append them to the options
            if (count($imagePaths) > 0) {
                $options = array_replace($options, $imagePaths);
            }
            $answer = $request->img_answer;
        } else if ($request->type == 'short_answer' || $request->type == 'fill_blank') {
            $options = [null, null, null, null];
            $answer = $request->short_answer;
        } else if ($request->type == 'true_false') {
            $options = ['Yes', 'No', null, null];
            $answer = $request->true_false;
        }
        // Gather the question data
        $questionData = [
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'type' => $request->type,
            'hygiene' => $request->hygiene,
            'options' => json_encode($options), // Store the options as JSON
            'correct_answer' => $answer,
        ];

        // Save the question data to the database
        if (Question::create($questionData)) {
            return redirect()->back()->with('success', 'Question added successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }
}
