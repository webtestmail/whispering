@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Management User</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Manage Users</li>
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
                        <a href="{{ route('admin.add.user') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>New User</span>
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
                                            <th>Company</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Phone</th>
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
   
    <script>
    let usersTable;
    $(document).ready(function () {
    usersTable = new DataTable('#example', {
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        "order": [[ 7, "desc" ]],
        info: true,
        lengthChange: true,
        pageLength: 10,
        ajax: '{{ route("admin.users.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'name', name: 'name'},
            { data: 'company', name: 'company', orderable: false, searchable: false},
            { data: 'role', name: 'role'},
            { data: 'email', name: 'email'},
            { data: 'phone', name: 'phone'},
            { data: 'is_active', name:'is_active' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
    });

    $(document).on('click', '.delete', function () {
        const id = $(this).data('id');
        if (!confirm('Are you sure you want to delete this user?')) {
            return;
        }

        $.ajax({
            url: '{{ route("admin.user.delete") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE',
                id: id
            },
            success: function (response) {
                if (window.alertify) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.message || 'User deleted successfully.');
                }
                if (usersTable) {
                    usersTable.ajax.reload(null, false);
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.errors?.id?.[0] || xhr.responseJSON?.message || 'Unable to delete user.';
                if (window.alertify) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(msg);
                } else {
                    alert(msg);
                }
            }
        });
    });
    </script>
@endsection
