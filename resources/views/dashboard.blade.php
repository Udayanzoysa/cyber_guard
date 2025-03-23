@extends('layouts.dashboard')
@section('title')
    <title>Dashboard</title>
@endsection
@section('main')

<div class="container">
    <div class="row">

        <div class="col-lg-8 col-12 mx-auto">
            <h1 class="text-white text-center">Cyber Guard</h1>

            <h6 class="text-center">Welcome to Dashboard</h6>
            <div class="text-center">
                <a href="{{route('list.quiz')}}" class="btn custom-btn custom-border-btn ms-3">Let's Start</a>
            </div>
        
        </div>

    </div>
</div>

@endsection
