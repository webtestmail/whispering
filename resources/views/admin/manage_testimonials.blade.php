@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Testimonial</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Manage Testimonial</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <!-- <a href="{{ route('admin.manage_faqs') }})" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a> -->
                    </div>
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        @if (Auth::guard('admin')->user()->role == 1)
                            <a href="{{ route('admin.add.testimonial') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Testimonial</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] start -->
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
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="testimonial_table">
                                    <thead>
                                        <tr>
                                            {{-- <th class="wd-30">
                                                    <div class="btn-group mb-1">
                                                        <div class="custom-control custom-checkbox ms-1">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="checkAllProposal">
                                                            <label class="custom-control-label"
                                                                for="checkAllProposal"></label>
                                                        </div>
                                                    </div>
                                                </th> --}}
                                            <th>S. No.</th>
                                            <th> Name</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
     <script>
            $(document).ready(function () {
            new DataTable('#testimonial_table', {
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                "order": [[ 8, "desc" ]],
                info: true,
                lengthChange: true,
                pageLength: 10,
                ajax: '{{ route("admin.testimonial.data") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    { data: 'client_name', name: 'client_name'},
                    { data: 'is_active', name:'is_active' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
        });

    </script>
@endsection
