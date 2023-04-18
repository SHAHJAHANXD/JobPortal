@extends('layout')
@section('title')
    Cybinix Job Portal | All Jobs
@endsection
@section('extra-heads')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
@endsection
@section('content')
    <style>
        .card-img-top {
            height: 110px;
            margin-top: 30px;
            width: 170px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12 offset-lg-2">
                <div class="card" style=" margin-top: 100px;">
                    <div class="card-body ">
                        <h3 class="text-center">All Available Jobs Category</h3>
                        <div class="row m-0">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <h3>Job Skills</h3>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12" style="    text-align: end;">
                                    <a href="{{ route('candidate.listallJobs') }}" class="btn btn-danger mb-2">View All
                                        Jobs</a>
                                </div>
                            </div>
                            <form action="{{ route('candidate.jobSearch') }}" method="GET">
                                <div class="row" style="justify-content: center;">
                                    <div class="col-lg-6">
                                        <input type="search" name="search" placeholder="Search Job Here..."
                                            class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="submit" class="btn btn-danger mb-2"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            @foreach ($skills as $skills)
                                <div class="col-xl-4 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <div class="card" style="background: white;">
                                            <img class="card-img-top" src="{{ $skills->img }}"
                                                alt="{{ $skills->name }} Image">
                                            <div class="card-body">
                                                <a href="{{ route('candidate.listallJobsBySkills', $skills->name) }}">
                                                    <h5 class="card-title"
                                                        style="    border-radius: 10px;
                                            border: 2px solid;
                                            background: black;
                                            padding: 10px;">
                                                        {{ $skills->name }} Jobs</h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection
