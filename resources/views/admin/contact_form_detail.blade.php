@extends('admin.layouts.admin-layout')

@section('page-content')
   <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Contact Querires</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"> Contact Querires</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                       <a href="{{ route('admin.manage_contact_form') }})" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-11">

                @if(isset($contact) && $contact)

                <div class="card border-0 shadow-lg rounded-4 p-4">

                    <!-- Top Section -->
                    <div class="row g-4">

                        <!-- Sender Info -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">

                                    <h5 class="fw-bold mb-3">
                                        <i class="feather-user text-primary me-2"></i>
                                        Sender Information
                                    </h5>

                                    <div class="row g-3">

                                        <div class="col-md-12">
                                            <label class="text-muted small"> Name</label>
                                            <div class="fw-semibold fs-5">{{ $contact->name ?? 'N/A' }}</div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="text-muted small">Subject</label>
                                            <div class="fw-semibold fs-5">{{ $contact->subject ?? 'N/A' }}</div>
                                        </div>

                                        <div class="col-12">
                                            <label class="text-muted small">Email Address</label>
                                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject ?? '' }}"
                                               class="fw-semibold text-primary fs-14 text-decoration-none">
                                                {{ $contact->email }}
                                            </a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm text-center h-100">
                                <div class="card-body d-flex flex-column justify-content-center">

                                    <i class="feather-zap text-primary fs-1 mb-3"></i>
                                    <h6 class="fw-bold mb-4">Quick Actions</h6>

                                    <div class="d-grid gap-2">
                                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject ?? '' }}"
                                           class="btn btn-primary">
                                            <i class="feather-mail me-2"></i>Reply
                                        </a>

                                        <a href="{{ route('admin.manage_contact_form') }}"
                                           class="btn btn-outline-secondary">
                                            <i class="feather-list me-2"></i>All Messages
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Message Section (NOW AT BOTTOM) -->
                    <div class="mt-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">

                                <h5 class="fw-bold mb-3">
                                    <i class="feather-message-circle text-primary me-2"></i>
                                    Message
                                </h5>

                                <div class="message-box p-3 bg-light rounded">
                                    {!! nl2br(e($contact->message ?? 'No message content')) !!}
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                @else

                <div class="text-center py-5">
                    <i class="feather-mail display-3 text-muted mb-3"></i>
                    <h4 class="text-muted">Message Not Found</h4>
                    <a href="{{ route('admin.manage_contact_form') }}" class="btn btn-primary mt-3">
                        Back to List
                    </a>
                </div>

                @endif

            </div>
        </div>
    </div>

</div>

<style>
.message-box {
    font-size: 15px;
    line-height: 1.7;
    max-height: 250px;
    overflow-y: auto;
}
</style>

@endsection