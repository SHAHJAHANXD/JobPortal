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

        @media (max-device-width: 600px) {
            .mobile-text {
                text-align: center !important;
            }
        }
    </style>
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12  offset-lg-2">
                <div class="card" style=" margin-top: 100px;">
                    <div class="card-body ">
                        <h3 class="text-center">All Available Jobs</h3>
                        <form action="{{ route('candidate.jobSearchFilter') }}" method="GET">
                            <div class="row" style="justify-content: center;     margin-top: 40px; margin-bottom: 40px;">
                                <div class="col-lg-2">
                                    <label class="mb-1"><strong>Experience</strong></label>
                                    <select  name="experience" id=""
                                        class="form-control" style="background: #2A2A2A">
                                        <option value="{{ $request->experience }}">{{ $request->experience ?? 'Select' }}</option>
                                        <option value="Less Then 1 Years">Less Then 1 Years</option>
                                        <option value="1-2 Years">1-2 Years</option>
                                        <option value="2-3 Years">2-3 Years</option>
                                        <option value="3-4 Years">3-4 Years</option>
                                        <option value="4-5 Years">4-5 Years</option>
                                        <option value="5-6 Years">5-6 Years</option>
                                        <option value="6-7 Years">6-7 Years</option>
                                        <option value="7-8 Years">7-8 Years</option>
                                        <option value="8-9 Years">8-9 Years</option>
                                        <option value="9-10 Years">9-10 Years</option>
                                        <option value="More Then 10 Years">More Then 10 Years</option>
                                    </select>
                                </div>
                                {{-- <input type="text" hidden value="{{ $appliedSkill }}" name="skills"> --}}
                                <div class="col-lg-2">
                                    <label class="mb-1"><strong>Skills</strong></label>
                                    <select  name="skills" id="" class="form-control"
                                        style="background: #2A2A2A">
                                        <option value="{{ $request->skills ?? $appliedSkill ?? ''}}">{{ $request->skills ?? $appliedSkill ?? 'Select' }}</option>
                                        @foreach ($skill as $skill)
                                            <option value="{{ $skill->name }}">{{ $skill->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label class="mb-1"><strong>Job Type</strong></label>
                                    <select  name="job_type" id="" class="form-control"
                                        style="background: #2A2A2A">
                                        <option value="{{ $request->job_type }}">{{ $request->job_type ?? 'Select' }}</option>
                                        @foreach ($job_type as $job_type)
                                            <option value="{{ $job_type->name }}">{{ $job_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label class="mb-1"><strong>Gender</strong></label>
                                    <select  name="gender" id="" class="form-control"
                                        style="background: #2A2A2A">
                                        <option value="{{ $request->gender }}">{{ $request->gender ?? 'Select' }}</option>

                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label class="mb-1"><strong>Location</strong></label>
                                    <select  name="location" id="" class="form-control"
                                        style="background: #2A2A2A">
                                        <option value="{{ $request->location }}">{{ $request->location ?? 'Select' }}</option>
                                        @foreach ($location as $location)
                                            <option value="{{ $location->name }}">{{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12" style="margin-top: auto; text-align: center;">
                                    <button type="submit" class="btn btn-danger mb-2"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
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
                                                    <p class="text-style">
                                                        @if ($PostJob->Users->avatar == true)
                                                            <img class="rounded-circle" width="35"
                                                                src="{{ $PostJob->Users->avatar }}"
                                                                alt="{{ $PostJob->Users->first_name }} {{ $PostJob->Users->last_name }} Image">
                                                        @else
                                                            <img class="rounded-circle" width="35"
                                                                src="{{ asset('dashboard') }}/images/guest.png"
                                                                alt="{{ $PostJob->Users->first_name }} {{ $PostJob->Users->last_name }} Image">
                                                        @endif
                                                        {{ $PostJob->Users->first_name }} {{ $PostJob->Users->last_name }}
                                                    </p>
                                                    <p class="text-style">Title: {{ $PostJob->title }}</p>
                                                    <p class="text-style">Location: {{ $PostJob->location }}</p>
                                                    <p class="text-style">Experience: {{ $PostJob->experience }}</p>
                                                    <p class="text-style">Skills: {{ $PostJob->skills }}</p>
                                                    <p class="text-style">Posted:
                                                        {{ $PostJob->created_at->diffForHumans() }}</p>

                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <a href="{{ route('candidate.jobDetails',$PostJob->id."?slug=".$PostJob->slug) }}">
                                                    <h5 class="card-title"
                                                        style="    border-radius: 10px;
                                            border: 2px solid;
                                            background: black;
                                            padding: 10px;">
                                                        View Details</h5>
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
