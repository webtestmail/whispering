@extends('admin.layouts.layout')

@push('page-wise-css')
    <style>
        .toogle-password {
            position: relative;
            left: 92%;
            transform: translateY(-33px);
            color: #0d6efd;
            cursor: pointer;
        }

        .login {
            background: #0d6efd;
            color: black;
        }

        .login:hover {
            background: #0d6efd;
        }
    </style>
@endpush

@section('page-content')
    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div
                        class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('images/company/1774333365_69c22db505229.png') }}" alt="" class="img-fluid">
                    </div>
                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">Login</h2>
                        <h4 class="fs-13 fw-bold mb-2">Login to your account</h4>
                        <p class="fs-12 fw-medium text-muted">Thank you for get back, let's access our the best recommendation for you.</p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        @if (session('email'))
                            <div class="alert alert-danger">
                                {{ session('email') }}
                            </div>
                        @endif
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

                        <form action="{{ route('admin_auth') }}" method="POST" class="w-100 mt-4 pt-2">
                            @csrf
                            <div class="mb-4">
                                <input type="email" class="form-control" name="email" placeholder="E-Mail or Username"
                                    value="" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                    value="" required>
                                <span class="fas fa-eye toogle-password"></span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="remember" id="rememberMe">
                                        <label class="custom-control-label c-pointer" for="rememberMe">Remember
                                            Me</label>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('password.request') }}" class="fs-11 text-primary">Forget
                                        password?</a>
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="login btn btn-lg  w-100">Login</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('page-wise-js')
    <script>
        $('.toogle-password').click(function() {
            var password = $(this).prev('input');
            const type = password.attr('type') === 'password' ? 'text' : 'password';
            password.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });
    </script>
@endpush
