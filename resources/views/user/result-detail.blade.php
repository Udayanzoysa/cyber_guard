@extends('layouts.dashboard')
@section('title')
    <title>My Results</title>
@endsection
@section('main')
    <style>
        .result-header {
            font-size: 24px;
            font-weight: bold;
        }

        .result-sub-header {
            color: gray;
            font-size: 14px;
        }

        .result {
            text-align: start;
            margin: 20px 0;
        }

        .pass {
            color: rgb(21, 255, 0);
            font-weight: bold;
        }

        .failed {
            color: red;
            font-weight: bold;
        }

        .score-section {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .details {
            background: #ffffff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .attempt-status {
            font-weight: bold;
        }

        .timeline {
            counter-reset: test 0;
            position: relative;
        }

        .timeline li {
            list-style: none;
            float: left;
            width: 33.3333%;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            font-size: 18px;
        }

        ul:nth-child(1) {
            color: #4caf50;
        }

        .timeline li:before {
            counter-increment: test;
            content: counter(test);
            width: 25px;
            height: 25px;
            border: 3px solid #4caf50;
            border-radius: 50%;
            display: block;
            text-align: center;
            line-height: 20px;
            font-size: 15px;
            margin: 0 auto 10px auto;
            background: #fff;
            color: #000;
            transition: all ease-in-out .3s;
            cursor: pointer;
        }

        .timeline li:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 1px;
            background-color: grey;
            top: 25px;
            left: -50%;
            z-index: -999;
            transition: all ease-in-out .3s;
        }

        .timeline li:first-child:after {
            content: none;
        }

        .timeline li.active-tl {
            color: #555555;
        }

        .timeline li.active-tl:before {
            background: #4caf50;
            color: #F1F1F1;
        }

        .timeline li.active-tl+li:after {
            background: #4caf50;
        }
    </style>
    <div class="container">
        <div class="result-header">{{ $result->title }} - Quiz Details</div>
        <div class="result-sub-header">Graded Quiz • In the course "{{ $result->title }}"</div>

        <div class="row mt-5">
            <div class="col-md-4">
                <div class="score">
                    <label for="Awarded score">Storage and dovice hygiene</label>
                    <h3>{{ $result->storage_dovice_score }}%</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="score">
                    <label for="Awarded score">Transmission & browsing hugiene</label>
                    <h3>{{ $result->transmission_browsing_score }}%</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="score">
                    <label for="Awarded score">Fb & social media hygione</label>
                    <h3>{{ $result->social_media_score }}%</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="score">
                    <label for="Awarded score">Authentication & credentials hygiene</label>
                    <h3>{{ $result->authentication_score }}%</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="score">
                    <label for="Awarded score">Email & Messaging hygiene</label>
                    <h3>{{ $result->messaging_score }}%</h3>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
        <div class="mt-5">
            <h3>Attempts Details</h3>
            <div class="details">
                <p>Last Attempt #1 of {{ $result->updated_at }}</p>
                <hr>
                <p>Attempt status:
                    @if (($result->achieved_score / $result->quiz_score) * 100 >= 50)
                        <span class="pass">Passed</span>
                    @else
                        <span class="failed">Failed</span>
                    @endif
                </p>
                <p>Correct answers: <b>{{ $result->achieved_score . '/' . $result->quiz_score }}</b></p>
                <p>Awarded score: <b>{{ ($result->achieved_score / $result->quiz_score) * 100 }}%</b></p>
                <p>Passing score: <b>80%</b></p>
                @php
                    $percentage = ($result->achieved_score / $result->quiz_score) * 100;
                    $level = 1;

                    if ($percentage > 50 && $percentage < 80) {
                        $level = 2;
                    } elseif ($percentage >= 80) {
                        $level = 3;
                    }
                @endphp
                <div class="row">
                    <p>Level:</p>
                    <ul class="timeline">
                        <li class="{{ $level == 1 ? 'active-tl' : '' }}">Level 1</li>
                        <li class="{{ $level == 2 ? 'active-tl' : '' }}">Level 2</li>
                        <li class="{{ $level == 3 ? 'active-tl' : '' }}">Level 3</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="/give-quiz/{{ $result->quiz_id }}" class="btn custom-btn custom-border-btn ms-3">Take Quiz to the
                Hightest Level</a>
        </div>
    </div>
@endsection
