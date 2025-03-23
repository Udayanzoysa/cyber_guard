@extends('layouts.dashboard')
@section('title')
    <title>Dashboard</title>
@endsection
@section('main')
    <div class="container">
        <header class="header">
            <h5 class="mb-2 text-center">Add Question for the Quiz: {{ $quiz_list->title }}</h5>
            <p id="description" class="text-center">
                Thank you for taking the time to help us improve the platform
            </p>
        </header>
        <div class="form-wrap">
            <form method="POST" action="{{ route('store.question') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="quiz_id" value="{{ $quiz_id }}">

                <div class="form-group">
                    <label>Question</label>
                    <input type="text" name="question" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Question Type</label>
                    <select name="type" id="question-type" class="form-control" required>
                        <option value="mcq">MCQ</option>
                        <option value="fill_blank">Fill in the Blanks</option>
                        <option value="true_false">True/False</option>
                        <option value="drag_drop">Drag & Drop</option>
                        <option value="image">Image-based</option>
                        <option value="scenario">Scenario-based</option>
                        <option value="short_answer">Short Answer</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Question Hygiene</label>
                    <select name="hygiene" id="question-type" class="form-control" required>
                        <option value="storage_dovice">Storage and dovice hygiene</option>
                        <option value="transmission_browsing">Transmission & browsing hugiene</option>
                        <option value="social_media">Fb & social media hygione.</option>
                        <option value="authentication">Authentication & credentials hygiene</option>
                        <option value="messaging">Email & Messaging hygiene.</option>
                    </select>
                </div>

                <div id="mcq-options" class="options-group">
                    <label for="options">Options</label>
                    <div class="form-group">
                        <input type="text" placeholder="Option A" name="options[]" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Option B" name="options[]" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Option C" name="options[]" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Option D" name="options[]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Define Correct Answer</label>
                        <select name="correct_answer" class="form-control">
                            <option value="0">A</option>
                            <option value="1">B</option>
                            <option value="2">C</option>
                            <option value="3">D</option>
                        </select>
                    </div>
                </div>

                <div id="img-options" class="options-group d-none">
                    <div class="form-group">
                        <label>Image 1</label>
                        <input type="file" name="image_1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Image 2</label>
                        <input type="file" name="image_2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Image 3</label>
                        <input type="file" name="image_3" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Image 4</label>
                        <input type="file" name="image_4" class="form-control">
                    </div>

                    <div class="form-group">
                        <select name="img_answer" class="form-control">
                            <option value="0">A</option>
                            <option value="1">B</option>
                            <option value="2">C</option>
                            <option value="3">D</option>
                        </select>
                    </div>
                </div>

                <div id="short-answer" class="options-group d-none">
                    <div class="form-group">
                        <label>Correct Answer</label>
                        <input type="text" name="short_answer" class="form-control">
                    </div>
                </div>
                <div class="form-group d-none" id="true-false">
                    <select name="true_false" class="form-control">
                        <option value="0">Yes</option>
                        <option value="1">No</option>
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">Submit</button>
            </form>

        </div>
    </div>
    <div class="container mt-5">
        <div class="text-center">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question</th>
                        <th scope="col">A</th>
                        <th scope="col">B</th>
                        <th scope="col">C</th>
                        <th scope="col">D</th>
                        <th scope="col">Correct</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sl = 1;
                    @endphp
                    @foreach ($questions as $question)
                        <tr>
                            <th scope="row">{{ $sl++ }}</th>
                            <td class="text-start">{{ $question->question }}</td>
                            @php
                                $options = json_decode($question->options, true); // Decode JSON
                            @endphp
                            @foreach ($options as $key => $option)
                                <td class="text-start">
                                    {{ strtoupper($option) }}:
                                </td>
                            @endforeach
                            <td>{{ $question->correct_answer }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function correctAnswer() {
            let a = document.getElementsByName('option_a')
            alert('a');
        }

        $(document).ready(function() {
            $("#question-type").change(function() {
                $(".options-group").addClass("d-none");
                $("#true-false").addClass("d-none");
                const selectedType = $(this).val();
                if (selectedType === "mcq") {
                    $("#mcq-options").removeClass("d-none");
                } else if (selectedType === "short_answer") {
                    $("#short-answer").removeClass("d-none");
                } else if (selectedType === "image") {
                    $("#img-options").removeClass("d-none");
                } else if (selectedType === "fill_blank") {
                    $("#short-answer").removeClass("d-none");
                } else if (selectedType === "scenario") {
                    $("#mcq-options").removeClass("d-none");
                } else if (selectedType === "true_false") {
                    $("#true-false").removeClass("d-none");
                }
            });
        });
    </script>
@endsection
