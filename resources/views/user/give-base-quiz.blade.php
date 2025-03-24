@extends('layouts.dashboard')
@section('title')
    <title>Quiz</title>
@endsection
@section('main')
    <div class="container text-center mt-5">
        <h3>Quiz Title: {{ $quiz->title }}</h3>
        <div id="timer_style" class="my-3 font-weight-bold text-danger">
            <label id="minutes">00</label>:<label id="seconds">00</label>
        </div>

        <form method="post" action="{{ route('store_base.answer') }}" id="quizForm">
            @csrf
            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" readonly>
            <input id="start_time" type="hidden" name="start_time" value="{{ $start_time }}" readonly>

            @foreach ($questions as $index => $question)
                <div class="question-container" id="question{{ $index }}"
                    style="display: {{ $index === 0 ? 'block' : 'none' }};">
                    <h4 class="mb-3">{{ $question->question }}</h4>
                    <div class="row text-start">
                        <div class="col-lg-8 offset-4">
                            @php
                                // Ensure options is always an array
                                $options = $question->options
                                    ? (is_array($question->options)
                                        ? $question->options
                                        : json_decode($question->options, true))
                                    : [];
                            @endphp

                            @if ($question->type == 'mcq' || $question->type == 'true_false')
                                @foreach ($options as $key => $option)
                                    @if ($option !== null)
                                        <div class="col-md-5 my-2">
                                            <label class="btn btn-block btn-lg btn-primary text-white answer-option"
                                                onclick="highlightSelection(this)">
                                                <input type="radio" name="answer[{{ $index }}]"
                                                    value="{{ $key }}" required hidden> {{ $option }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            @elseif ($question->type == 'fill_blank' || $question->type == 'short_answer')
                                <input type="text" name="answer[{{ $index }}]" class="form-control">
                            @elseif ($question->type == 'image')
                                @foreach ($options as $key => $option)
                                    <div class="col-md-5 my-2">
                                        <label class="btn btn-block btn-lg btn-primary text-white answer-option"
                                            onclick="highlightSelection(this)">
                                            <img src="{{ asset($option) }}"
                                                style="width: 200px;height: 200px;object-fit: contain;">
                                            <input type="radio" name="answer[{{ $index }}]"
                                                value="{{ $key }}" required hidden>
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="mt-4">
                <button type="button" id="prevBtn" onclick="prevQuestion()" class="btn btn-secondary"
                    style="display: none;">Previous</button>
                <button type="button" id="nextBtn" onclick="nextQuestion()" class="btn btn-primary">Next
                    Question</button>
                <button type="submit" id="submitBtn" class="btn btn-success" style="display: none;">Submit Answers</button>
            </div>
        </form>
    </div>

    <script>
        var currentQuestion = 0;
        var totalQuestions = {{ count($questions) }};

        function showQuestion(index) {
            document.querySelectorAll('.question-container').forEach((q, i) => {
                q.style.display = i === index ? 'block' : 'none';
            });
            document.getElementById('prevBtn').style.display = index > 0 ? 'inline-block' : 'none';
            document.getElementById('nextBtn').style.display = index < totalQuestions - 1 ? 'inline-block' : 'none';
            document.getElementById('submitBtn').style.display = index === totalQuestions - 1 ? 'inline-block' : 'none';
        }

        function nextQuestion() {
            if (currentQuestion < totalQuestions - 1) {
                currentQuestion++;
                showQuestion(currentQuestion);
            }
        }

        function prevQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                showQuestion(currentQuestion);
            }
        }

        function highlightSelection(element) {
            let options = element.parentElement.parentElement.querySelectorAll('.answer-option');
            options.forEach(option => option.classList.remove('btn-dark'));
            element.classList.add('btn-dark');
        }

        function previewImage(event, index) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('preview' + index);
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        showQuestion(currentQuestion);
    </script>

    <script>
        var minutesLabel = document.getElementById("minutes");
        var secondsLabel = document.getElementById("seconds");
        var totalSeconds = 0;
        setInterval(setTime, 1000);

        function setTime() {
            ++totalSeconds;
            secondsLabel.innerHTML = pad(totalSeconds % 60);
            minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        }

        function pad(val) {
            return val < 10 ? "0" + val : val;
        }

        function timeUp() {
            document.getElementById('timer_style').innerHTML = "Time is Up!";
            document.getElementById('quizForm').submit();
        }

        window.setTimeout(timeUp, {{ $quiz->duration * 60 * 1000 }});
    </script>
@endsection
