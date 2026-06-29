@php
    $contact = resolve(App\Http\Controllers\Admin\CompanyController::class)->getCompanyData();
@endphp

@include('header')
@yield('content')
@include('footer')
