@extends('layout')
@section('title')
    Cybinix Job Portal | Applied Jobs of {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
@endsection
@section('extra-heads')
    <link href="{{ asset('dashboard') }}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('extra-scripts')
    <script src="{{ asset('dashboard') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('dashboard') }}/js/plugins-init/datatables.init.js"></script>
@endsection
@section('content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Profile Datatable</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>

                                            <th class="text-center">Title</th>
                                            <th class="text-center">CV</th>
                                            <th class="text-center">Cover Letter</th>
                                            <th class="text-center">Candidate Name</th>
                                            <th class="text-center">Candidate Email</th>
                                            <th class="text-center">Candidate Whatsapp</th>
                                            <th class="text-center">Candidate Availability</th>
                                            <th class="text-center">Candidate Age</th>
                                            <th class="text-center">Candidate Experience</th>
                                            <th class="text-center">Candidate Designation</th>
                                            <th class="text-center">Candidate Location</th>
                                            <th class="text-center">Apply Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_jobs as $all_jobs)
                                            <tr>
                                                <td class="text-center">{{ $all_jobs->PostJobs->title }}</td>
                                                <td class="text-center"><a
                                                        href="{{ env('APP_URL') . 'cv/' . $all_jobs->cv }}"
                                                        download="">Download CV</a></td>
                                                <td class="text-center">{{ $all_jobs->cover_letter }}</td>
                                                <td class="text-center">
                                                    {{ $all_jobs->user->first_name . ' ' . $all_jobs->user->last_name }}
                                                </td>
                                                <td class="text-center"><a
                                                        href="mailto:{{ $all_jobs->user->email }}">{{ $all_jobs->user->email }}</a>
                                                </td>
                                                <td class="text-center"><a
                                                        href="https://api.whatsapp.com/send?phone={{ $all_jobs->user->wa_no }}" target="_block">Contact</a>
                                                </td>
                                                <td class="text-center">{{ $all_jobs->user->availability }}</td>
                                                <td class="text-center">{{ $all_jobs->user->age }}</td>
                                                <td class="text-center">{{ $all_jobs->user->experience }}</td>
                                                <td class="text-center">{{ $all_jobs->user->designation }}</td>
                                                <td class="text-center">{{ $all_jobs->user->location }}</td>
                                                <td class="text-center">{{ $all_jobs->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
