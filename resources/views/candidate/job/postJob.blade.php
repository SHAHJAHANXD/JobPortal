@extends('layout')
@section('title')
    Cybinix Job Portal | Post New Job
@endsection
@section('extra-heads')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
@endsection
@section('content')
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12">
                <div class="card" style=" margin-top: 100px;  ">
                    <div class="card-body ">
                        <h3 class="text-center">Add new job</h3>
                        <div class="row m-0">
                            <h3>Job Content</h3>
                            <div class="col-xl-8 col-md-8 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Job Title <span style="color: red">*</span></strong></label>
                                    <input required type="text" class="form-control" placeholder="Enter Job Title"
                                        name="title" required>
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Job Status <span
                                                style="color: red">*</span></strong></label>
                                    <br>
                                    <label><input type="checkbox" name="status[]" required value="1"> Publish</label>
                                    <br>
                                    <label><input type="checkbox" name="status[]" required value="0"> Draft</label>
                                    @if ($errors->has('status'))
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Job Description <span
                                                style="color: red">*</span></strong></label>
                                    <textarea class="ckeditor form-control" name="desc"></textarea>
                                    @if ($errors->has('desc'))
                                        <span class="text-danger">{{ $errors->first('desc') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Gender <span
                                                style="color: red">*</span></strong></label>
                                                <select name="gender" required id="" class="form-control" style="background: #2A2A2A">
                                                    <option value="">Select</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                    @if ($errors->has('new_password'))
                                        <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Experience <span style="color: red">*</span></strong></label>
                                    <select required name="experience" id=""
                                        class="form-control" style="background: #2A2A2A">
                                        <option value="">Select</option>
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
                                        <span
                                            class="text-danger">{{ $errors->first('experience') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Category <span style="color: red">*</span></strong></label>
                                    <select required name="category" id=""
                                        class="form-control" style="background: #2A2A2A">
                                        <option value="">Select</option>
                                        @foreach ($category as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span
                                            class="text-danger">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Job Type <span style="color: red">*</span></strong></label>
                                    <select required name="job_type" id=""
                                        class="form-control" style="background: #2A2A2A">
                                        <option value="">Select</option>
                                        @foreach ($type as $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('job_type'))
                                        <span
                                            class="text-danger">{{ $errors->first('job_type') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>No of Recruitments <span style="color: red">*</span></strong></label>
                                    <select required name="recruitments" id=""
                                        class="form-control" style="background: #2A2A2A">
                                        <option value="">Select</option>
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
                                        <span
                                            class="text-danger">{{ $errors->first('recruitments') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 sign" style="margin-top: 20px">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Job Location <span style="color: red">*</span></strong></label>
                                    <select required name="location" id=""
                                        class="form-control" style="background: #2A2A2A">
                                        <option value="">Select</option>
                                        @foreach ($location as $location)
                                        <option value="{{ $location->name }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('location'))
                                        <span
                                            class="text-danger">{{ $errors->first('location') }}</span>
                                    @endif
                                </div>
                            </div>
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
