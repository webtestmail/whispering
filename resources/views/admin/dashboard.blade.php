@extends('admin.layouts.admin-layout')

@php
$users = \App\Models\User::all();
@endphp

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10" style="border-right:none !important;">Dashboard</h5>
                </div>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <!-- <div id="reportrange" class="reportrange-picker d-flex align-items-center">
                            <span class="reportrange-picker-field"></span>
                        </div> -->
                        <div class="dropdown filter-dropdown">
                            <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown" data-bs-offset="0, 10"
                                data-bs-auto-close="outside">
                                <i class="feather-filter me-2"></i>
                                <span>Filter</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Role"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer" for="Role">Role</label>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Team"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer" for="Team">Team</label>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Email"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer" for="Email">Email</label>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Member"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer" for="Member">Member</label>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Recommendation"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer"
                                            for="Recommendation">Recommendation</label>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="feather-plus me-3"></i>
                                    <span>Create New</span>
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="feather-filter me-3"></i>
                                    <span>Manage Filter</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-md-none d-flex align-items-center">
                    <a href="javascript:void(0)" class="page-header-right-open-toggle">
                        <i class="feather-align-right fs-20"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->
        <!-- [ Main Content ] start -->
        <div class="main-content">
            <div class="row">
                <!-- [Invoices Awaiting Payment] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-users"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $users->count() }}</span></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Users
                                            </h3>
                                    </div>
                                </div>
                                <a href="javascript:void(0);" class="">
                                    <i class="feather-more-vertical"></i>
                                </a>
                            </div>
                            <div class="pt-4 d-none">
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0);"
                                        class="fs-12 fw-medium text-muted text-truncate-1-line">Total Membership Purchased
                                    </a>
                                    <div class="w-100 text-end">
                                        <span class="fs-12 text-dark">$5,569</span>
                                        <span class="fs-11 text-muted">(56%)</span>
                                    </div>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 56%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Invoices Awaiting Payment] end -->
                <!-- [Converted Leads] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-calendar"></i>
                                    </div>
                                    <div>
                                        @php
                                        
                                        $activeEvents = \App\Models\Admin\Event::where('is_active',true)->get();
                                        @endphp
                                        <div class="fs-4 fw-bold text-dark"><span class="counter"> {{ $activeEvents->count() }}</span></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">Active Events</h3>
                                    </div>
                                </div>
                                <a href="javascript:void(0);" class="">
                                    <i class="feather-more-vertical"></i>
                                </a>
                            </div>
                            <div class="pt-4 d-none">
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0);"
                                        class="fs-12 fw-medium text-muted text-truncate-1-line">Converted Leads
                                    </a>
                                    <div class="w-100 text-end">
                                        <span class="fs-12 text-dark">52 Completed</span>
                                        <span class="fs-11 text-muted">(63%)</span>
                                    </div>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 63%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Converted Leads] end -->
                <!-- [Projects In Progress] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-users"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $applications->count() }}</span></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Registrations
                                        </h3>
                                    </div>
                                </div>
                                <a href="javascript:void(0);" class="">
                                    <i class="feather-more-vertical"></i>
                                </a>
                            </div>
                            <div class="pt-4 ">
                                <div class="d-flex align-items-center justify-content-between">
                                
                                    <div class="w-100 text-end">
                                       
                                       
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Projects In Progress] end -->
                <!-- [Conversion Rate] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-activity"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><span class="counter">0</span>
                                        </div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">New Leads</h3>
                                    </div>
                                </div>
                                <a href="javascript:void(0);" class="">
                                    <i class="feather-more-vertical"></i>
                                </a>
                            </div>
                            <div class="pt-4 d-none">
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0);" class="fs-12 fw-medium text-muted text-truncate-1-line">
                                        Conversion Rate
                                    </a>
                                    <div class="w-100 text-end">
                                        <span class="fs-12 text-dark">$2,254</span>
                                        <span class="fs-11 text-muted">(46%)</span>
                                    </div>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 46%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Conversion Rate] end -->
                <!-- [Payment Records] start -->
                <div class="col-xxl-8">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Registeration Pipeline</h5>
                            <div class="card-header-action">
                                <div class="card-header-btn">
                                    <div data-bs-toggle="tooltip" title="Delete">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger"
                                            data-bs-toggle="remove"> </a>
                                    </div>
                                    <div data-bs-toggle="tooltip" title="Refresh">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning"
                                            data-bs-toggle="refresh"> </a>
                                    </div>
                                    <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success"
                                            data-bs-toggle="expand"> </a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown"
                                        data-bs-offset="25, 25">
                                        <div data-bs-toggle="tooltip" title="Options">
                                            <i class="feather-more-vertical"></i>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-at-sign"></i>New</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-calendar"></i>Event</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-bell"></i>Snoozed</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-trash-2"></i>Deleted</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-settings"></i>Settings</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-life-buoy"></i>Tips & Tricks</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body custom-card-action p-0">
                            <div id="payment-records-chart"></div>
                        </div>
                        <div class="card-footer">
                            <div class="row g-4">
                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Approved applications</div>
                                        <h6 class="fw-bold text-dark">{{ $applications->where('status', 'approved')->count() }}</h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 81%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Pending applications</div>
                                        <h6 class="fw-bold text-dark">{{ $applications->where('status', 'pending')->count() }}</h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 82%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Rejected applications</div>
                                        <h6 class="fw-bold text-dark">{{ $applications->where('status', 'rejected')->count() }}</h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 82%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Payment Records] end -->

                             <!-- [Upcoming Events] start -->
                <div class="col-xxl-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Upcoming Events</h5>
                            <div class="card-header-action">
                                <a href="{{ route('admin.manage_events') }}" class="avatar-text avatar-sm"
                                    data-bs-toggle="tooltip" title="Manage Events">
                                    <i class="feather-info"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr class="border-b">
                                            <th scope="row">Date</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(($upcomingEvents ?? collect()) as $event)
                                            @php
                                                $eventStart = $event->start_date;
                                                $eventEnd = $event->end_date ?? $eventStart;
                                                $today = now()->startOfDay();

                                                if (! $event->is_active) {
                                                    $statusLabel = 'Inactive';
                                                    $statusClass = 'bg-soft-secondary text-secondary';
                                                } elseif ($today->lt($eventStart)) {
                                                    $statusLabel = 'Upcoming';
                                                    $statusClass = 'bg-soft-primary text-primary';
                                                } else {
                                                    $statusLabel = 'Ongoing';
                                                    $statusClass = 'bg-soft-success text-success';
                                                }

                                                $timeRange = 'Time TBA';
                                                if ($event->open_time && $event->close_time) {
                                                    $timeRange = \Carbon\Carbon::parse($event->open_time)->format('g:ia')
                                                        . ' - '
                                                        . \Carbon\Carbon::parse($event->close_time)->format('g:ia');
                                                } elseif ($event->open_time) {
                                                    $timeRange = \Carbon\Carbon::parse($event->open_time)->format('g:ia');
                                                }

                                                $editUrl = route('admin.event.edit', \Illuminate\Support\Facades\Crypt::encrypt($event->id));
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="wd-50 ht-50 bg-soft-primary text-primary lh-1 d-flex align-items-center justify-content-center flex-column rounded-2 schedule-date">
                                                            <span class="fs-18 fw-bold mb-1 d-block">{{ $eventStart?->format('d') }}</span>
                                                            <span class="fs-10 fw-semibold text-uppercase d-block">{{ $eventStart?->format('M') }}</span>
                                                        </div>
                                                        <a href="{{ $editUrl }}">
                                                            <span class="d-block fw-semibold text-dark text-truncate-1-line">{{ $event->title }}</span>
                                                            <span class="fs-11 fw-normal text-muted text-truncate-1-line">{{ $timeRange }}</span>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="avatar-text avatar-md"
                                                            data-bs-toggle="dropdown" data-bs-offset="0, 10">
                                                            <i class="feather-more-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{ $editUrl }}" class="dropdown-item">
                                                                <i class="feather-edit-2 me-2"></i>Edit
                                                            </a>
                                                            @if($event->slug)
                                                                <a href="{{ route('event.detail', $event->slug) }}" class="dropdown-item" target="_blank">
                                                                    <i class="feather-external-link me-2"></i>View on site
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4">
                                                    <span class="text-muted fs-12">No upcoming events found.</span>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(($upcomingEvents ?? collect())->isNotEmpty())
                            <a href="{{ route('admin.manage_events') }}"
                                class="card-footer fs-11 fw-bold text-uppercase text-center py-3 text-dark text-decoration-none">
                                View All Events
                            </a>
                        @endif
                    </div>
                </div>
                <!-- [Upcoming Events] end -->
                <!--! BEGIN: [Upcoming Schedule] !-->
                <div class="col-xxl-4 d-none">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Upcoming Schedule</h5>
                            <div class="card-header-action">
                                <div class="card-header-btn">
                                    <div data-bs-toggle="tooltip" title="Delete">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger"
                                            data-bs-toggle="remove"> </a>
                                    </div>
                                    <div data-bs-toggle="tooltip" title="Refresh">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning"
                                            data-bs-toggle="refresh"> </a>
                                    </div>
                                    <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success"
                                            data-bs-toggle="expand"> </a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown"
                                        data-bs-offset="25, 25">
                                        <div data-bs-toggle="tooltip" title="Options">
                                            <i class="feather-more-vertical"></i>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-at-sign"></i>New</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-calendar"></i>Event</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-bell"></i>Snoozed</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-trash-2"></i>Deleted</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-settings"></i>Settings</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-life-buoy"></i>Tips & Tricks</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!--! BEGIN: [Events] !-->
                            <div class="p-3 border border-dashed rounded-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div
                                            class="wd-50 ht-50 bg-soft-primary text-primary lh-1 d-flex align-items-center justify-content-center flex-column rounded-2 schedule-date">
                                            <span class="fs-18 fw-bold mb-1 d-block">20</span>
                                            <span class="fs-10 fw-semibold text-uppercase d-block">Dec</span>
                                        </div>
                                        <div class="text-dark">
                                            <a href="javascript:void(0);" class="fw-bold mb-2 text-truncate-1-line">React
                                                Dashboard
                                                Design</a>
                                            <span class="fs-11 fw-normal text-muted text-truncate-1-line">11:30am
                                                - 12:30pm</span>
                                        </div>
                                    </div>
                                    <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Janette Dalton">
                                            <img src="./../assets/images/avatar/2.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Michael Ksen">
                                            <img src="./../assets/images/avatar/3.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Socrates Itumay">
                                            <img src="./../assets/images/avatar/4.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Marianne Audrey">
                                            <img src="./../assets/images/avatar/6.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-text avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Explorer More">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--! BEGIN: [Events] !-->
                            <div class="p-3 border border-dashed rounded-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div
                                            class="wd-50 ht-50 bg-soft-warning text-warning lh-1 d-flex align-items-center justify-content-center flex-column rounded-2 schedule-date">
                                            <span class="fs-18 fw-bold mb-1 d-block">30</span>
                                            <span class="fs-10 fw-semibold text-uppercase d-block">Dec</span>
                                        </div>
                                        <div class="text-dark">
                                            <a href="javascript:void(0);" class="fw-bold mb-2 text-truncate-1-line">Admin
                                                Design Concept</a>
                                            <span class="fs-11 fw-normal text-muted text-truncate-1-line">10:00am
                                                - 12:00pm</span>
                                        </div>
                                    </div>
                                    <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Janette Dalton">
                                            <img src="./../assets/images/avatar/2.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Michael Ksen">
                                            <img src="./../assets/images/avatar/3.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Marianne Audrey">
                                            <img src="./../assets/images/avatar/5.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Marianne Audrey">
                                            <img src="./../assets/images/avatar/6.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-text avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Explorer More">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--! BEGIN: [Events] !-->
                            <div class="p-3 border border-dashed rounded-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div
                                            class="wd-50 ht-50 bg-soft-success text-success lh-1 d-flex align-items-center justify-content-center flex-column rounded-2 schedule-date">
                                            <span class="fs-18 fw-bold mb-1 d-block">17</span>
                                            <span class="fs-10 fw-semibold text-uppercase d-block">Dec</span>
                                        </div>
                                        <div class="text-dark">
                                            <a href="javascript:void(0);"
                                                class="fw-bold mb-2 text-truncate-1-line">Standup Team Meeting</a>
                                            <span class="fs-11 fw-normal text-muted text-truncate-1-line">8:00am -
                                                9:00am</span>
                                        </div>
                                    </div>
                                    <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Janette Dalton">
                                            <img src="./../assets/images/avatar/2.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Michael Ksen">
                                            <img src="./../assets/images/avatar/3.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Socrates Itumay">
                                            <img src="./../assets/images/avatar/4.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Marianne Audrey">
                                            <img src="./../assets/images/avatar/5.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-text avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Explorer More">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--! BEGIN: [Events] !-->
                            <div class="p-3 border border-dashed rounded-3 mb-2">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div
                                            class="wd-50 ht-50 bg-soft-danger text-danger lh-1 d-flex align-items-center justify-content-center flex-column rounded-2 schedule-date">
                                            <span class="fs-18 fw-bold mb-1 d-block">25</span>
                                            <span class="fs-10 fw-semibold text-uppercase d-block">Dec</span>
                                        </div>
                                        <div class="text-dark">
                                            <a href="javascript:void(0);" class="fw-bold mb-2 text-truncate-1-line">Zoom
                                                Team Meeting</a>
                                            <span class="fs-11 fw-normal text-muted text-truncate-1-line">03:30pm
                                                - 05:30pm</span>
                                        </div>
                                    </div>
                                    <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Janette Dalton">
                                            <img src="./../assets/images/avatar/2.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Socrates Itumay">
                                            <img src="./../assets/images/avatar/4.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Marianne Audrey">
                                            <img src="./../assets/images/avatar/5.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-image avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Marianne Audrey">
                                            <img src="./../assets/images/avatar/6.png" class="img-fluid"
                                                alt="image" />
                                        </a>
                                        <a href="javascript:void(0)" class="avatar-text avatar-md"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Explorer More">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0);"
                            class="card-footer fs-11 fw-bold text-uppercase text-center py-4">Upcomming
                            Schedule</a>
                    </div>
                </div>
                <!--! END: [Upcoming Schedule] !-->
  
  
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
