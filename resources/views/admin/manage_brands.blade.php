@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Management {{$currentPageName}}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Manage {{$currentPageName}}</li>
                </ul>
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
                        <a href="{{ route($addNewData) }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>New {{$currentPageName}}</span>
                        </a>
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
                                <table class="table table-hover" id="example">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Name</th>
                                            <th>Brand Image</th>
                                            <th>Status</th>
                                            <th>Created at</th>
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
    </div>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
    let dataTableInstance;
    $(document).ready(function () {
   dataTableInstance =new DataTable('#example', {
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        "order": [[ 8, "desc" ]],
        info: true,
        lengthChange: true,
        pageLength: 10,
        ajax: '{{ route("admin." . $currentPageData . ".data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'name', name: 'name'},
            { data: 'brand_image', name: 'brand_image'},
            { data: 'is_active', name:'is_active' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});

$(document).on('click', '.delete', function () {
    let id = $(this).data('id');
    let model = $(this).data('model');
    let deleteUrl = '{{ route($deleteUrl) }}'; 
    if (confirm(`Are you sure you want to delete this {{ $currentPageName }}?`)) {
        $.ajax({
            url: deleteUrl,
            type: 'POST', 
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE', // Laravel's way of spoofing a DELETE request
                id: id,
                model:model
            },
            success: function (response) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.message);
                
                let row = $('.delete[data-id="' + id + '"]').closest('tr');
                dataTableInstance.row(row).remove().draw(false);
            },
            error: function (xhr) {
                // 4. FIX: Use 'xhr' instead of 'response' which is undefined here
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong';
                alertify.set('notifier', 'position', 'top-right');
                    alertify.success(errorMsg);
            }
        });
    }
});

    </script>
@endsection
