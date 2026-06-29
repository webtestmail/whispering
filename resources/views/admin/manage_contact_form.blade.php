@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Leads & Enquiries</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Leads & Enquiries</li>
                </ul>
            </div>
        </div>
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card stretch stretch-full">
                        <div class="card-header d-flex flex-wrap gap-2 align-items-center">
                            <select id="filterFormType" class="form-select form-select-sm" style="width:auto;">
                                <option value="">All Types</option>
                                <option value="contact">Contact</option>
                                <option value="booking">Booking</option>
                                <option value="newsletter">Newsletter</option>
                            </select>
                            <select id="filterStatus" class="form-select form-select-sm" style="width:auto;">
                                <option value="">All Status</option>
                                <option value="new">New</option>
                                <option value="read">Read</option>
                                <option value="replied">Replied</option>
                            </select>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contact_form_table">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Received</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const table = new DataTable('#contact_form_table', {
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[7, 'desc']],
                info: true,
                lengthChange: true,
                pageLength: 10,
                ajax: {
                    url: '{{ route("admin.contactform.data") }}',
                    data: function (d) {
                        d.form_type = $('#filterFormType').val();
                        d.status = $('#filterStatus').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'form_type_label', name: 'form_type' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone', defaultContent: '—' },
                    { data: 'subject', name: 'subject', defaultContent: '—' },
                    { data: 'status_badge', name: 'status', orderable: false, searchable: false },
                    { data: 'submitted_at', name: 'created_at' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#filterFormType, #filterStatus').on('change', function () {
                table.ajax.reload();
            });
        });
    </script>
@endsection
