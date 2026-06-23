@php
    $user = Auth::user();
   
    $logo = \App\Models\Admin\Company::select('company_logo','company_icon')->first();
    $company_icon = $logo->company_icon;
@endphp
<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.my-dashboard') }}" class="b-brand">
                <img src="{{ asset(Session::get('company_icon')) }}" alt="{{ Session::get('company_name') }}"
                    class="logo logo-lg" height="90px" width="90%" style="padding: 10px;" />
                <img src="{{ asset(Session::get('company_icon')) }}" alt="{{ Session::get('company_name') }}"
                    class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="{{ route('admin.my-dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>

                @if($user->getIsAdminAttribute())
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-users"></i></span>
                        <span class="nxl-mtext">Users</span><span class="nxl-arrow"><i
                                class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_users') }}">Manage Users</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-file-text"></i></span>
                        <span class="nxl-mtext">Pages</span><span class="nxl-arrow"><i
                                class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_pages') }}">Manage Pages</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_banners') }}">Manage Banners</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                        <span class="nxl-mtext">Content</span><span class="nxl-arrow"><i
                                class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_services') }}">Manage Services</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_blogs') }}">Manage Blogs</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_brands') }}">Manage Brands</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_testimonials') }}">Manage Testimonials</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">Settings</span><span class="nxl-arrow"><i
                                class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_company') }}">Manage Company</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_contact') }}">Manage Contact</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_socials') }}">Manage Socials</a>
                        </li>
                    </ul>
                </li>
                @endif

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-mail"></i></span>
                        <span class="nxl-mtext">Forms</span><span class="nxl-arrow"><i
                                class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.manage_contact_form') }}">Manage Contact Queries</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
