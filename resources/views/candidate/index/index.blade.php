@extends('layout')
@section('title')
Cybinix Job Portal | Candidate Dashboard
@endsection
@section('content')
    <div class="content-body" style="min-height: 0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="card Expense overflow-hidden">
                                    <div class="card-body p-4 p-lg-3 p-xl-4 ">
                                        <div class="students1 one d-flex align-items-center justify-content-between ">
                                            <div class="content">
                                                <h2 class="mb-0">{{ Auth::user()->views }}</h2>
                                                <span class="mb-2 fs-14">Profile Views</span>
                                            </div>
                                            <div>
                                                <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                    <svg width="60" height="58" viewBox="0 0 60 58"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M39.0469 2.3125C38.3437 3.76563 38.9648 5.52344 40.418 6.22657C44.4609 8.17188 47.8828 11.1953 50.3203 14.9805C52.8164 18.8594 54.1406 23.3594 54.1406 28C54.1406 41.3125 43.3125 52.1406 30 52.1406C16.6875 52.1406 5.85937 41.3125 5.85937 28C5.85937 23.3594 7.18359 18.8594 9.66797 14.9688C12.0937 11.1836 15.5273 8.16016 19.5703 6.21485C21.0234 5.51173 21.6445 3.76563 20.9414 2.30079C20.2383 0.847664 18.4922 0.226569 17.0273 0.929694C12 3.34376 7.74609 7.09375 4.73437 11.8047C1.64062 16.6328 -1.56336e-06 22.2344 -1.31134e-06 28C-9.60967e-07 36.0156 3.11719 43.5508 8.78906 49.2109C14.4492 54.8828 21.9844 58 30 58C38.0156 58 45.5508 54.8828 51.2109 49.2109C56.8828 43.5391 60 36.0156 60 28C60 22.2344 58.3594 16.6328 55.2539 11.8047C52.2305 7.10547 47.9766 3.34375 42.9609 0.929693C41.4961 0.238287 39.75 0.84766 39.0469 2.3125V2.3125Z"
                                                            fill="#53CAFD" />
                                                        <path
                                                            d="M41.4025 26.4414C41.9767 25.8671 42.258 25.1171 42.258 24.3671C42.258 23.6171 41.9767 22.8671 41.4025 22.2929L34.0314 14.9218C32.9533 13.8437 31.5236 13.2578 30.0119 13.2578C28.5002 13.2578 27.0587 13.8554 25.9923 14.9218L18.6212 22.2929C17.4728 23.4414 17.4728 25.2929 18.6212 26.4414C19.7697 27.5898 21.6212 27.5898 22.7697 26.4414L27.0939 22.1171L27.0939 38.7695C27.0939 40.3867 28.4064 41.6992 30.0236 41.6992C31.6408 41.6992 32.9533 40.3867 32.9533 38.7695L32.9533 22.1054L37.2775 26.4296C38.4025 27.5781 40.2541 27.5781 41.4025 26.4414Z"
                                                            fill="#53CAFD" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="card overflow-hidden">
                                    <div class="card-body p-4 p-lg-3 p-xl-4">
                                        <div class="students1 three d-flex align-items-center justify-content-between">
                                            <div class="content">
                                                <h2 class="mb-0">{{ $applied_jobs }}</h2>
                                                <span class="fs-14">Applied Jobs</span>
                                            </div>
                                            <div class="newCustomers">
                                                <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                    <div id="NewCustomers"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="card student-chart">
                                <div class="card-header border-0 pb-0">
                                    <h4>Your Balance</h4>
                                </div>
                                <div class="card-body pt-0 custome-tooltip">
                                    <canvas id="activeUser"></canvas>
                                    <div
                                        class="d-flex justify-content-between align-items-center flex-wrap std-info d-none">
                                        <h4 class="fs-18 font-w600 mb-0">12.345</h4>
                                        <span><small class="text-secondary">5.4% </small>than last year</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header border-0 pb-4 arrow">
                                    <div>
                                        <h5 class="fs-18 font-w600">Admission Summary</h5>
                                        <h4 class="fs-24 font-w600 mb-0 d-inline-flex me-2">$4,563</h4>
                                        <span class="d-inline-flex align-items-center"><small
                                                class="text-success font-w500 me-1">+1.6%</small> than last
                                            week</span>
                                    </div>
                                    <svg class="theme-col" width="45" height="45" viewBox="0 0 52 52"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="52" height="52" rx="26" fill="var(--bs-body-bg)" />
                                        <g clip-path="url(#clip0)">
                                            <path
                                                d="M17.0704 21.5996C17.0704 21.6034 17.0704 21.6073 17.0704 21.6111L17.0626 33.4848C17.0629 33.5788 17.0733 33.6725 17.0937 33.7643L17.1713 34.0284L17.249 34.1837L17.3344 34.2691C17.4413 34.4241 17.5755 34.5583 17.7305 34.6652L17.8081 34.7428L17.9013 34.836L18.1032 34.8981C18.2168 34.9317 18.3343 34.9501 18.4527 34.9525L30.3885 34.9292C31.183 34.9324 31.8297 34.2908 31.8329 33.4963C31.8329 33.4925 31.8329 33.4886 31.8329 33.4848C31.8144 32.6991 31.1819 32.0666 30.3962 32.0481L23.3062 32.0404C23.003 32.0374 22.7595 31.7891 22.7625 31.4859C22.7639 31.3448 22.8195 31.2097 22.9179 31.1085L34.481 19.5454C35.0429 18.9836 35.043 18.0727 34.4811 17.5108C33.9193 16.9489 33.0084 16.9489 32.4465 17.5107C32.4465 17.5107 32.4464 17.5108 32.4464 17.5108L20.8833 29.0739C20.6659 29.2853 20.3182 29.2804 20.1068 29.063C20.0085 28.9618 19.9528 28.8267 19.9514 28.6856L19.9592 21.6111C19.9447 20.8195 19.3064 20.1812 18.5148 20.1667C17.7202 20.1635 17.0735 20.805 17.0704 21.5996Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath>
                                                <rect width="24" height="24" fill="white"
                                                    transform="translate(25.9997 42.9706) rotate(-135)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="card-body py-2 custome-tooltip">
                                    <div id="chartBarRunning" class="chartBarRunning"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="copyright">
                    <p>Copyright © Designed &amp; Developed by <a href="https://cybinix.com/" target="_blank">
                            Cybinix</a> 2023</p>
                </div>
            </div>

        </div>
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Add Person</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="PersonName1" class="form-label d-block">Enter Name</label>
                        <input type="text" id="PersonName1" class="form-control w-100 mb-3" placeholder="Username">
                        <label for="PersonPosition1" class="form-label d-block">Enter Position</label>
                        <input type="text" id="PersonPosition1" class="form-control w-100" placeholder="Position">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
