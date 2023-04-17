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
            margin-right: auto;
        }

        .text-style {
            line-height: 0;
            margin-top: 18px !important;
            color: black;
            font-weight: 600;
        }
    </style>
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12">
                <div class="card" style=" margin-top: 100px;">
                    <div class="card-body ">
                        <h3 class="text-center">All Available Jobs</h3>
                        <div class="row m-0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>All Jobs</h3>
                                </div>
                            </div>
                            @foreach ($PostJob as $PostJob)
                                <div class="col-xl-6 col-md-6 sign mobile-text" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <div class="card" style="background: white;">
                                            <div class="row">
                                                <div class="col-lg-6" style="text-align: center;">
                                                    <img class="card-img-top" src="{{ $PostJob->Skills->img }}"
                                                        alt="{{ $PostJob->name }} Image">
                                                </div>
                                                <div class="col-lg-6" style="margin-top: auto;">
                                                    <p class="text-style"> @if ($PostJob->Users->avatar == true)
                                                        <img class="rounded-circle" width="35" src="{{ $PostJob->Users->avatar }}" alt="{{ $PostJob->Users->first_name }} {{ $PostJob->Users->last_name }} Image">
                                                    @else
                                                        <img class="rounded-circle" width="35"
                                                            src="{{ asset('dashboard') }}/images/guest.png" alt="{{ $PostJob->Users->first_name }} {{ $PostJob->Users->last_name }} Image">
                                                    @endif
                                                    {{ $PostJob->Users->first_name }} {{ $PostJob->Users->last_name }}
                                                </p>
                                                    <p class="text-style">Title: {{ $PostJob->title }}</p>
                                                    <p class="text-style">Location: {{ $PostJob->location }}</p>
                                                    <p class="text-style">Experience: {{ $PostJob->experience }}</p>
                                                    <p class="text-style">Skills: {{ $PostJob->skills }}</p>
                                                    <p class="text-style">Posted: {{ $PostJob->created_at->diffForHumans() }}</p>

                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <a>
                                                    <h5 class="card-title"
                                                        style="    border-radius: 10px;
                                            border: 2px solid;
                                            background: black;
                                            padding: 10px;">
                                                        Apply Now</h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="    text-align: center;    margin-bottom: 50px;">
                            <a href="{{ $loadmore }}" class="btn btn-danger mb-2">Load More</a>
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
