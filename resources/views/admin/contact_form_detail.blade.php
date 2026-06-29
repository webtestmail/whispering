@extends('admin.layouts.admin-layout')

@section('page-content')
   <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Lead Detail</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.manage_contact_form') }}">Leads</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                       <a href="{{ route('admin.manage_contact_form') }}" class="page-header-right-close-toggle">
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

                    <div class="row g-4">

                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">

                                    <h5 class="fw-bold mb-3">
                                        <i class="feather-user text-primary me-2"></i>
                                        Lead Information
                                    </h5>

                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="text-muted small">Type</label>
                                            <div class="fw-semibold">{{ $contact->form_type_label }}</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="text-muted small">Status</label>
                                            <div class="fw-semibold text-capitalize">{{ $contact->status ?? 'new' }}</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="text-muted small">Name</label>
                                            <div class="fw-semibold fs-5">{{ $contact->name ?? 'N/A' }}</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="text-muted small">Subject</label>
                                            <div class="fw-semibold">{{ $contact->subject ?? 'N/A' }}</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="text-muted small">Email</label>
                                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject ?? '' }}"
                                               class="fw-semibold text-primary text-decoration-none d-block">
                                                {{ $contact->email }}
                                            </a>
                                        </div>

                                        @if($contact->phone)
                                        <div class="col-md-6">
                                            <label class="text-muted small">Phone</label>
                                            <a href="tel:{{ $contact->phone }}" class="fw-semibold text-decoration-none d-block">
                                                {{ $contact->phone }}
                                            </a>
                                        </div>
                                        @endif

                                        @if($contact->guests)
                                        <div class="col-md-4">
                                            <label class="text-muted small">Guests</label>
                                            <div class="fw-semibold">{{ $contact->guests }}</div>
                                        </div>
                                        @endif

                                        @if($contact->checkin)
                                        <div class="col-md-4">
                                            <label class="text-muted small">Check-in</label>
                                            <div class="fw-semibold">{{ $contact->checkin->format('d M Y') }}</div>
                                        </div>
                                        @endif

                                        @if($contact->checkout)
                                        <div class="col-md-4">
                                            <label class="text-muted small">Check-out</label>
                                            <div class="fw-semibold">{{ $contact->checkout->format('d M Y') }}</div>
                                        </div>
                                        @endif

                                        @if($contact->nights)
                                        <div class="col-md-4">
                                            <label class="text-muted small">Nights</label>
                                            <div class="fw-semibold">{{ $contact->nights }}</div>
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <label class="text-muted small">Received</label>
                                            <div class="fw-semibold">{{ $contact->created_at?->format('d M Y, h:i A') }}</div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm text-center h-100">
                                <div class="card-body d-flex flex-column justify-content-center">

                                    <i class="feather-zap text-primary fs-1 mb-3"></i>
                                    <h6 class="fw-bold mb-4">Quick Actions</h6>

                                    <div class="d-grid gap-2">
                                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject ?? '' }}"
                                           class="btn btn-primary">
                                            <i class="feather-mail me-2"></i>Reply by Email
                                        </a>

                                        <button type="button" class="btn btn-outline-success" id="markRepliedBtn"
                                            data-id="{{ encrypt($contact->id) }}">
                                            <i class="feather-check me-2"></i>Mark as Replied
                                        </button>

                                        <button type="button" class="btn btn-outline-danger" id="deleteLeadBtn"
                                            data-id="{{ encrypt($contact->id) }}">
                                            <i class="feather-trash-2 me-2"></i>Delete
                                        </button>

                                        <a href="{{ route('admin.manage_contact_form') }}"
                                           class="btn btn-outline-secondary">
                                            <i class="feather-list me-2"></i>All Leads
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    @if($contact->message)
                    <div class="mt-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">

                                <h5 class="fw-bold mb-3">
                                    <i class="feather-message-circle text-primary me-2"></i>
                                    Message
                                </h5>

                                <div class="message-box p-3 bg-light rounded">
                                    {!! nl2br(e($contact->message)) !!}
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                @else

                <div class="text-center py-5">
                    <i class="feather-mail display-3 text-muted mb-3"></i>
                    <h4 class="text-muted">Lead Not Found</h4>
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

<script>
document.getElementById('markRepliedBtn')?.addEventListener('click', function () {
    fetch('{{ route("admin.contactform.status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ id: this.dataset.id, status: 'replied' })
    }).then(r => r.json()).then(data => {
        if (data.success) location.reload();
    });
});

document.getElementById('deleteLeadBtn')?.addEventListener('click', function () {
    if (!confirm('Delete this lead permanently?')) return;
    fetch('{{ route("admin.contactform.delete") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ id: this.dataset.id })
    }).then(r => r.json()).then(data => {
        if (data.success) window.location.href = '{{ route("admin.manage_contact_form") }}';
    });
});
</script>

@endsection
