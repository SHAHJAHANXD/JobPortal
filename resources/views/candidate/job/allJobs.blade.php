@extends('layout')
@section('title')
    Cybinix Job Portal
@endsection
@section('extra-heads')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
@endsection
@section('content')
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12">
                <div class="card" style=" margin-top: 100px;">
                    <div class="card-body ">
                        <h3 class="text-center">All Available Jobs</h3>
                        <div class="row m-0">
                            <h3>Job Skills</h3>
                            @foreach ($skills as $skills)
                            <div class="col-xl-4 col-md-6 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <div class="card" style="width: 18rem; background: white;    box-shadow: 0px 0px 7px 3px #AAA; ">
                                        <img class="card-img-top" src="{{ $skills->img }}" alt="{{ $skills->name }} Image" style="height: 150px; margin-top: 30px; ">
                                        <div class="card-body">
                                          <a href=""><h5 class="card-title" style="    border-radius: 10px;
                                            border: 2px solid;
                                            background: black;
                                            padding: 10px;">{{ $skills->name }} Jobs</h5></a>
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
