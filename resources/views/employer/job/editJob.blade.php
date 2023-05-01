@extends('layout')
@section('title')
    Cybinix Job Portal | Edit Job
@endsection
@section('extra-heads')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
@endsection
@section('content')
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12">
                <div class="card" style=" margin-top: 100px;  ">
                    <form action="{{ route('employer.postEditJob') }}" method="POST">
                        @csrf
                        <div class="card-body ">
                            <h3 class="text-center">Edit Job {{ $job->title }}</h3>
                            <div class="row m-0">
                                <h3>Job Content</h3>
                                <div class="col-xl-12 col-md-12 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Job Title <span
                                                    style="color: red">*</span></strong></label>
                                        <input required type="text" class="form-control" value="{{ $job->title }}"
                                            placeholder="Enter Job Title" name="title">
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <input type="text" hidden name="id" value="{{ $id }}">
                                <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Job Skills <span
                                                    style="color: red">*</span></strong></label>
                                        <select name="skills" required class="form-control" style="background: #2A2A2A">
                                            <option value="{{ $job->skills }}">{{ $job->skills }}</option>
                                            @foreach ($Skills as $Skills)
                                                <option value="{{ $Skills->name }}">{{ $Skills->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('skills'))
                                            <span class="text-danger">{{ $errors->first('skills') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Job Status <span
                                                    style="color: red">*</span></strong></label>
                                        <select name="status" required class="form-control" style="background: #2A2A2A">
                                            @if ($job->status == 0)
                                            <option value="{{ $job->status }}">Draft</option>
                                            @endif
                                            @if ($job->status == 1)
                                            <option value="{{ $job->status }}">Publish</option>
                                            @endif
                                            <option value="1">Publish</option>
                                            <option value="0">Draft</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Job Description <span
                                                    style="color: red">*</span></strong></label>
                                        <textarea class="ckeditor form-control" name="desc">{!! $job->desc !!}</textarea>
                                        @if ($errors->has('desc'))
                                            <span class="text-danger">{{ $errors->first('desc') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Gender <span
                                                    style="color: red">*</span></strong></label>
                                        <select name="gender" required class="form-control" style="background: #2A2A2A">
                                            <option value="{{ $job->gender }}">{{ $job->gender }}</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="text-danger">{{ $errors->first('gender') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Experience <span
                                                    style="color: red">*</span></strong></label>
                                        <select required name="experience" class="form-control" style="background: #2A2A2A">
                                            <option value="{{ $job->experience }}">{{ $job->experience }}</option>
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
                                        @if ($errors->has('experience'))
                                            <span class="text-danger">{{ $errors->first('experience') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Category <span
                                                    style="color: red">*</span></strong></label>
                                        <select required name="category" class="form-control" style="background: #2A2A2A">
                                            <option value="{{ $job->category }}">{{ $job->category }}</option>
                                            @foreach ($category as $category)
                                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span class="text-danger">{{ $errors->first('category') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Job Type <span
                                                    style="color: red">*</span></strong></label>
                                        <select required name="job_type" class="form-control"
                                            style="background: #2A2A2A">
                                            <option value="{{ $job->job_type }}">{{ $job->job_type }}</option>
                                            @foreach ($type as $type)
                                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('job_type'))
                                            <span class="text-danger">{{ $errors->first('job_type') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>No of Recruitments <span
                                                    style="color: red">*</span></strong></label>
                                        <select required name="recruitments" class="form-control"
                                            style="background: #2A2A2A">
                                            <option value="{{ $job->recruitments }}">{{ $job->recruitments }}</option>
                                            <option value="10">0-10</option>
                                            <option value="20">0-20</option>
                                            <option value="30">0-30</option>
                                            <option value="40">0-40</option>
                                            <option value="50">0-50</option>
                                            <option value="60">0-60</option>
                                            <option value="70">0-70</option>
                                            <option value="80">0-80</option>
                                            <option value="90">0-90</option>
                                            <option value="100">0-100</option>
                                        </select>
                                        @if ($errors->has('recruitments'))
                                            <span class="text-danger">{{ $errors->first('recruitments') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Job Location <span
                                                    style="color: red">*</span></strong></label>
                                        <select required name="location" class="form-control"
                                            style="background: #2A2A2A">
                                            <option value="{{ $job->location }}">{{ $job->location }}</option>
                                            @foreach ($location as $location)
                                                <option value="{{ $location->name }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('location'))
                                            <span class="text-danger">{{ $errors->first('location') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block">Update Job</button>
                                </div>
                            </div>
                    </form>
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
