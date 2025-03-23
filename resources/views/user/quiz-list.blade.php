@extends('layouts.dashboard')
@section('title')
    <title>Dashboard</title>
@endsection
@section('main')
    <!-- <h1>Quiz List</h1>
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col">Duration</th>
            </tr>
            </thead>
            <tbody>
            @php
                $sl=1;
            @endphp
            @foreach($quiz_list as $quiz)
                <tr>
                    <th scope="row">{{$sl++}}</th>
                    <td><a href="/give-quiz/{{$quiz->id}}">{{$quiz->title}}</a></td>
                    <td>{{$quiz->from_time}}</td>
                    <td>{{$quiz->to_time}}</td>
                    <td>{{$quiz->duration}} minutes</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div> -->
    <div class="container">
    <div class="row">
    @php
        $sl=1;
    @endphp
    @foreach($quiz_list as $quiz)   
        <div class="col-lg-4">
            <div class="card" style="border: #80d0c7 1px solid;">
            <div class="card-body">
                <h5 class="card-title">{{$quiz->title}}</h5>
                <p class="card-text">{{$quiz->updated_at}}</p>
                <a href="/give-quiz/{{$quiz->id}}" class="btn btn-sm custom-btn custom-border-btn ms-3">Start Quiz</a>
            </div>
            </div>
        </div>
        @endforeach  
        </div>
        </div>
@endsection
