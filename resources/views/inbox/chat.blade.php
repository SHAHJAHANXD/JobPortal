@extends('layout')
@section('title')
    Cybinix Job Portal
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-5">
                            <div class="card chat dz-chat-history-box ">
                                <div class="card-body contacts_body p-0 dz-scroll  " id="DLAB_W_Contacts_Body">
                                    <h1 class="text-center">Inbox</h1>
                                    <ul class="contacts"
                                        style="overflow: auto; padding: 20px;height: 600px; display: block;">
                                        @if (Auth::user()->role == 'Candidate')
                                            @php
                                                $chat = \App\Models\appliedjob::where('candidate_id', Auth::user()->id)
                                                    ->with('userCandidate')
                                                    ->orderBy('id',;desc)
                                                    ->get();
                                            @endphp
                                        @endif
                                        @if (Auth::user()->role == 'Employer')
                                            @php
                                                $chat = \App\Models\appliedjob::where('employer_id', Auth::user()->id)
                                                    ->with('userEmployer')
                                                    ->get();
                                            @endphp
                                        @endif
                                        @foreach ($chat as $chats)
                                            @if (Auth::user()->role == 'Candidate')
                                                <a href="{{ route('candidate.getMessages', $chats->employer_id) }}">
                                            @endif
                                            @if (Auth::user()->role == 'Employer')
                                                <a href="{{ route('employer.getMessages', $chats->candidate_id) }}">
                                            @endif
                                            @if (Auth::user()->role == 'Admin')
                                                <a href="{{ route('admin.getMessages', $chats->id) }}">
                                            @endif
                                            <li class="active dz-chat-user">
                                                <div class="d-flex bd-highlight" style=" padding: 5px;">
                                                    <div class="img_cont">
                                                        @if (Auth::user()->role == 'Employer')
                                                            @if ($chats->userCandidate->avatar == true)
                                                                <img src="{{ $chats->userCandidate->avatar }}"
                                                                    class="rounded-circle user_img"
                                                                    alt="{{ $chats->userCandidate->first_name ?? '' }} {{ $chats->userCandidate->last_name ?? '' }} Image"
                                                                    style="    height: 40px;">
                                                            @else
                                                                <img src="{{ asset('dashboard/images/guest.png') }}"
                                                                    class="rounded-circle user_img" alt="Guest Image"
                                                                    style="    height: 40px;">
                                                            @endif
                                                        @endif
                                                        @if (Auth::user()->role == 'Candidate')
                                                            @if ($chats->userEmployer->avatar == true)
                                                                <img src="{{ $chats->userEmployer->avatar }}"
                                                                    class="rounded-circle user_img"
                                                                    alt="{{ $chats->userEmployer->first_name ?? '' }} {{ $chats->userEmployer->last_name ?? '' }} Image"
                                                                    style="    height: 40px;">
                                                            @else
                                                                <img src="{{ asset('dashboard/images/guest.png') }}"
                                                                    class="rounded-circle user_img" alt="Guest Image"
                                                                    style="    height: 40px;">
                                                            @endif
                                                        @endif
                                                    </div>
                                                    @if (Auth::user()->role == 'Candidate')
                                                        <div class="user_info" style="    margin-left: 10px;">
                                                            <span>{{ $chats->userCandidate->first_name ?? '' }}
                                                                {{ $chats->userCandidate->last_name ?? '' }}</span>
                                                            <p>{{ $chats->userCandidate->first_name ?? '' }}
                                                                {{ $chats->userCandidate->last_name ?? '' }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if (Auth::user()->role == 'Employer')
                                                        <div class="user_info" style="    margin-left: 10px;">
                                                            <span>{{ $chats->userEmployer->first_name ?? '' }}
                                                                {{ $chats->userEmployer->last_name ?? '' }}</span>
                                                            <p>{{ $chats->userEmployer->first_name ?? '' }}
                                                                {{ $chats->userEmployer->last_name ?? '' }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-9 col-lg-8 col-md-7">
                            <div class="card chat dz-chat-history-box ">
                                <div class="card-header chat-list-header text-center">
                                    @if ($user->first_name ?? '' == true)
                                        <a href="javascript:void(0);" class="dz-chat-history-back">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <rect fill="#ffffff" opacity="0.3"
                                                        transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000) "
                                                        x="14" y="7" width="2" height="10"
                                                        rx="1" />
                                                    <path
                                                        d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z"
                                                        fill="#ffffff" fill-rule="nonzero"
                                                        transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) " />
                                                </g>
                                            </svg>
                                        </a>

                                        <div>
                                            <h6 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                        </div>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <circle fill="#ffffff" cx="5" cy="12"
                                                            r="2" />
                                                        <circle fill="#ffffff" cx="12" cy="12"
                                                            r="2" />
                                                        <circle fill="#ffffff" cx="19" cy="12"
                                                            r="2" />
                                                    </g>
                                                </svg></a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li class="dropdown-item"><i
                                                        class="fa fa-user-circle text-primary me-2"></i>
                                                    View
                                                    profile</li>
                                            </ul>
                                        </div>

                                </div>
                                <div class="card-body msg_card_body dz-scroll" id="DLAB_W_Contacts_Body3">
                                    @foreach ($message as $chat)
                                        @if ($chat->from_user_id == Auth::user()->id)
                                            <div class="d-flex justify-content-end mb-4">
                                                <div class="msg_cotainer_send"
                                                    style="margin-top: auto; margin-bottom: auto; margin-right: 10px; background: #1B74E4; padding: 3px; border-radius: 5px; color: white">
                                                    {{ $chat->message ?? '' }}
                                                    <span
                                                        class="msg_time_send">({{ \Carbon\Carbon::parse($chat->created_at)->diffForHumans() }})</span>
                                                </div>
                                                <div class="img_cont_msg">
                                                    @if (Auth::user()->avatar == true)
                                                        <img src="{{ Auth::user()->avatar }}"
                                                            class="rounded-circle user_img_msg" alt=""
                                                            style="height: 50px; border: 2px solid;">
                                                    @else
                                                        <img src="{{ asset('dashboard/images/guest.png') }}"
                                                            class="rounded-circle user_img_msg" alt=""
                                                            style="height: 50px; border: 2px solid;">
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-start mb-4">
                                                <div class="img_cont_msg">
                                                    @if ($user->avatar == true)
                                                        <img src="{{ $user->avatar }}"
                                                            class="rounded-circle user_img_msg" alt=""
                                                            style="height: 50px; border: 2px solid;">
                                                    @else
                                                        <img src="{{ asset('dashboard/images/guest.png') }}"
                                                            class="rounded-circle user_img_msg" alt=""
                                                            style="height: 50px; border: 2px solid;">
                                                    @endif
                                                </div>
                                                <div class="msg_cotainer"
                                                    style="margin-top: auto; margin-bottom: auto; margin-left: 10px; background: gray; padding: 3px; border-radius: 5px; color: white">
                                                    {{ $chat->message ?? '' }}
                                                    <span
                                                        class="msg_time_send">({{ \Carbon\Carbon::parse($chat->created_at)->diffForHumans() }})</span>
                                                </div>

                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="card-footer type_msg">
                                    @if (Auth::user()->role == 'Candidate')
                                        <form action="{{ route('candidate.sendMessage') }}" method="POST">
                                    @endif
                                    @if (Auth::user()->role == 'Employer')
                                        <form action="{{ route('employer.sendMessage') }}" method="POST">
                                    @endif
                                    @if (Auth::user()->role == 'Admin')
                                        <form action="{{ route('admin.sendMessage') }}" method="POST">
                                    @endif
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" hidden value="{{ $user->id }}" name="to_user_id">
                                        <textarea class="form-control" name="message" placeholder="Type your message..."></textarea>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-location-arrow"></i></button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            @else
                            </div>
                            <h1 class="text-center">Cybinix Job Portal Inbox!</h1>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->role == 'Candidate')
    @endif

    @if (Auth::user()->role == 'Employer')
        <form action="{{ route('employer.sendMessage') }}" method="POST">
    @endif
    @if (Auth::user()->role == 'Admin')
        <form action="{{ route('admin.sendMessage') }}" method="POST">
    @endif
@section('extra-scripts')
    <script type="text/javascript" src="/assets/admin/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(realTime, 2000);
        });

        function realTime() {
            $.ajax({
                type: 'post',
                url: '/chat/get',
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data) {
                    $('#message').replaceWith(' <ul class="media-list" id="message"></ul>');
                    for (var i = 0; i < data.length; i++) {
                        $('#message').append(
                            ' <li class="media"><div class="media-body"><div class="media"><div class="media-body">' +
                            data[i].message + '<br/><small class="text-muted">' + data[i].from_name + '|' +
                            data[i].created_at + '</small><hr/></div></div></div></li>')
                    }
                },
            });
            setTimeout(realTime, 2000);
        }
        $(document).on('click', '#send', function() {
            $.ajax({
                type: 'post',
                url: '/chat/send',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'from_name': $('input[name=from_name]').val(),
                    'message': $('input[name=message]').val(),
                },
                success: function(data) {
                    $('#message').append(
                        '  <li class="media"><div class="media-body"><div class="media"><div class="media-body">' +
                        data.message + '<br/><small class="text-muted">' + data.from_name + '|' +
                        data.created_at + '</small><hr/></div></div></div></li>');
                }
            })

            $('input[name=message]').val('');
        });
    </script>
@endsection
@endsection
