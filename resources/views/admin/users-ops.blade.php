@extends('admin.layouts.admin-layout')

@section('page-content')
@php
    $profile = $user->userprofile;
    $companyLinks = $user->companylinks;
    $appearance = $user->appearance;
    $mainPoc = $user->mainPointOfContact;
    $customLinks = old('custom_link_captions')
        ? collect(old('custom_link_captions'))->map(fn ($caption, $i) => [
            'caption' => $caption,
            'url' => old('custom_link_urls.'.$i),
        ])
        : collect(optional($companyLinks)->custom_links ?? []);
    $selectedCategoryIds = $user->productCategories->pluck('id')->toArray();
    $selectedSubCategoryIds = $user->productSubCategories->pluck('id')->toArray();
    $selectedTradeIds = $user->tradeSectors->pluck('id')->toArray();
    $selectedTemperatureIds = $user->temperatures->pluck('id')->toArray();
    $currentCompanyType = old('organization_type', optional($profile)->company_type ?? '');
    $selectedProfileCountryId = old('country_id', optional($profile)->country_id ?? '');
    $selectedContactCountryId = old('country', optional($primaryCompanyContact)->country ?? '');
    $promoBannerYes = old('promo_banner', optional($appearance)->display_cover_image ? 'yes' : 'no') === 'yes';
@endphp
<div class="nxl-content">
    <form action="{{ route('admin.user.edit', $user->encrypted_id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="page-header sticky-top">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">User Management</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.manage_users') }}">All Users</a></li>
                    <li class="breadcrumb-item">View / Modify</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('admin.manage_users') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather-save me-2"></i>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
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

            <div class="row">
                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary"><i class="feather-user me-2"></i>Account Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                                    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
                                    @error('username')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                                    @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Role</label>
                                    <select name="role" class="form-select">
                                        <option value="0" {{ (int) old('role', $user->role) === 0 ? 'selected' : '' }}>Member</option>
                                        <option value="1" {{ (int) old('role', $user->role) === 1 ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ (int) old('role', $user->role) === 2 ? 'selected' : '' }}>Sub Member</option>
                                        <option value="3" {{ (int) old('role', $user->role) === 3 ? 'selected' : '' }}>Sub Sub Member</option>
                                        <option value="4" {{ (int) old('role', $user->role) === 4 ? 'selected' : '' }}>Sub Admin</option>
                                    </select>
                                    @error('role')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Account Status</label>
                                    <select name="user_status" class="form-select">
                                        <option value="1" {{ old('user_status', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('user_status', $user->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                                    @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary"><i class="feather-briefcase me-2"></i>Company Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Company Name</label>
                                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', optional($profile)->company_name) }}">
                                    @error('company_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Slogan</label>
                                    <input type="text" name="slogan" class="form-control" value="{{ old('slogan', optional($profile)->slogan) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Company Type</label>
                                    <select name="organization_type" class="form-select">
                                        <option value="">Select Company Type</option>
                                        @foreach($memberCategories as $memberCategory)
                                            <option value="{{ $memberCategory->name }}" {{ $currentCompanyType == $memberCategory->name ? 'selected' : '' }}>
                                                {{ $memberCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Number of Employees</label>
                                    <input type="number" name="employee_count" class="form-control" value="{{ old('employee_count', optional($profile)->number_of_employees) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Country</label>
                                    <select name="country_id" class="form-select">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (string) $selectedProfileCountryId === (string) $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Profile Published</label>
                                    <select name="profile_is_active" class="form-select">
                                        <option value="1" {{ old('profile_is_active', optional($profile)->is_active) == 1 ? 'selected' : '' }}>Published</option>
                                        <option value="0" {{ old('profile_is_active', optional($profile)->is_active) == 0 ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small text-uppercase text-muted">Company Description</label>
                                    <textarea name="company_description" class="form-control" rows="4">{{ old('company_description', optional($profile)->company_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary"><i class="feather-layers me-2"></i>Products &amp; Brands</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-4">
                                    <label class="form-label fw-semibold">Trade Sectors</label>
                                    <div class="border rounded p-3" style="max-height: 220px; overflow-y: auto;">
                                        @foreach($trade_sectors as $sector)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="trade[]" value="{{ $sector->id }}" id="trade_{{ $sector->id }}"
                                                    {{ in_array($sector->id, old('trade', $selectedTradeIds), true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="trade_{{ $sector->id }}">{{ $sector->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label fw-semibold">Product Categories</label>
                                    <div class="border rounded p-3" style="max-height: 220px; overflow-y: auto;">
                                        @foreach($product_categories as $parentCat)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="product_category[]" value="{{ $parentCat->id }}" id="pc_{{ $parentCat->id }}"
                                                    {{ in_array($parentCat->id, old('product_category', $selectedCategoryIds), true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pc_{{ $parentCat->id }}">{{ $parentCat->name }}</label>
                                            </div>
                                            @if($parentCat->subCategories->isNotEmpty())
                                                <div class="ms-3 mb-2">
                                                    @foreach($parentCat->subCategories as $childCat)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="product_sub_category[]" value="{{ $childCat->id }}" id="psc_{{ $childCat->id }}"
                                                                {{ in_array($childCat->id, old('product_sub_category', $selectedSubCategoryIds), true) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="psc_{{ $childCat->id }}">{{ $childCat->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label fw-semibold">Temperature</label>
                                    <div class="border rounded p-3 mb-3" style="max-height: 160px; overflow-y: auto;">
                                        @foreach($temperatures as $temperature)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="temperature[]" value="{{ $temperature->id }}" id="temp_{{ $temperature->id }}"
                                                    {{ in_array($temperature->id, old('temperature', $selectedTemperatureIds), true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="temp_{{ $temperature->id }}">{{ $temperature->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <label class="form-label fw-semibold">Brands</label>
                                    <input type="text" name="brands" class="form-control" value="{{ old('brands', $user->brands->pluck('name')->implode(', ')) }}" placeholder="Brand A, Brand B">
                                    <small class="text-muted">Separate brand names with commas.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary"><i class="feather-link me-2"></i>Company Links</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Website URL</label>
                                    <input type="url" name="website_url" class="form-control" value="{{ old('website_url', optional($companyLinks)->website_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">LinkedIn URL</label>
                                    <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', optional($companyLinks)->linkedin_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Facebook URL</label>
                                    <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', optional($companyLinks)->facebook_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">X URL</label>
                                    <input type="url" name="twitter_urls" class="form-control" value="{{ old('twitter_urls', optional($companyLinks)->twitter_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Instagram URL</label>
                                    <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', optional($companyLinks)->instagram_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">YouTube URL</label>
                                    <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', optional($companyLinks)->youtube_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Pinterest URL</label>
                                    <input type="url" name="pinterest_url" class="form-control" value="{{ old('pinterest_url', optional($companyLinks)->pinterest_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">WhatsApp URL or Number</label>
                                    <input type="text" name="whatsapp_url_or_number" class="form-control" value="{{ old('whatsapp_url_or_number', optional($companyLinks)->whatsapp_url_or_number) }}">
                                </div>
                            </div>

                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Custom Links</h6>
                                <button type="button" class="btn btn-sm btn-light-primary" id="addCustomLinkBtn">
                                    <i class="feather-plus me-1"></i> Add Link
                                </button>
                            </div>
                            <div id="customLinksContainer">
                                @forelse($customLinks as $index => $customLink)
                                    <div class="row g-3 mb-3 custom-link-row border rounded p-3">
                                        <div class="col-md-5">
                                            <label class="form-label small text-uppercase text-muted">Caption (max 12)</label>
                                            <input type="text" name="custom_link_captions[]" class="form-control" maxlength="12" value="{{ $customLink['caption'] ?? '' }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small text-uppercase text-muted">URL</label>
                                            <input type="url" name="custom_link_urls[]" class="form-control" value="{{ $customLink['url'] ?? '' }}" placeholder="https://">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger remove-custom-link w-100">Remove</button>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <small class="text-muted">Up to 10 custom links.</small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary"><i class="feather-map-pin me-2"></i>Company Contact</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small text-uppercase text-muted">Main Address</label>
                                    <input type="text" name="main_address" class="form-control" value="{{ old('main_address', optional($primaryCompanyContact)->main_address) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Google Maps URL</label>
                                    <input type="url" name="map_url" class="form-control" value="{{ old('map_url', optional($primaryCompanyContact)->google_map_link) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-uppercase text-muted">Country</label>
                                    <select name="country" class="form-select">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (string) $selectedContactCountryId === (string) $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Extra Addresses</h6>
                                <button type="button" class="btn btn-sm btn-light-primary" id="addExtraAddressBtn">
                                    <i class="feather-plus me-1"></i> Add Address
                                </button>
                            </div>
                            <div id="extraAddressesContainer">
                                @foreach(old('extra_addresses', $extraCompanyContacts->pluck('main_address')->toArray()) as $index => $extraAddress)
                                    <div class="row g-3 mb-3 extra-address-row border rounded p-3">
                                        <div class="col-12">
                                            <label class="form-label small text-uppercase text-muted">Address</label>
                                            <input type="text" name="extra_addresses[]" class="form-control" value="{{ $extraAddress }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small text-uppercase text-muted">Maps URL</label>
                                            <input type="url" name="extra_map_urls[]" class="form-control" value="{{ old('extra_map_urls.'.$index, optional($extraCompanyContacts->get($index))->google_map_link) }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small text-uppercase text-muted">Country</label>
                                            <select name="extra_countries[]" class="form-select">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    @php $extraCountry = old('extra_countries.'.$index, optional($extraCompanyContacts->get($index))->country); @endphp
                                                    <option value="{{ $country->id }}" {{ (string) $extraCountry === (string) $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger remove-extra-address w-100">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary"><i class="feather-phone me-2"></i>Point of Contact</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small text-uppercase text-muted">Contact Photo</label>
                                    @if(optional($mainPoc)->image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $mainPoc->image) }}" alt="Contact photo" class="img-thumbnail" style="max-height: 100px;">
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" name="remove_main_contact_image" value="1" id="remove_main_contact_image">
                                                <label class="form-check-label" for="remove_main_contact_image">Remove photo</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="main_contact_image" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-uppercase text-muted">Contact Name</label>
                                    <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name', optional($mainPoc)->contact_name) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-uppercase text-muted">Surname</label>
                                    <input type="text" name="contact_surname" class="form-control" value="{{ old('contact_surname', optional($mainPoc)->contact_surname) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-uppercase text-muted">Position</label>
                                    <input type="text" name="contact_position" class="form-control" value="{{ old('contact_position', optional($mainPoc)->contact_position) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-uppercase text-muted">Gender</label>
                                    <input type="text" name="contact_gender" class="form-control" value="{{ old('contact_gender', optional($mainPoc)->contact_gender) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-uppercase text-muted">Email</label>
                                    <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', optional($mainPoc)->contact_email) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-uppercase text-muted">Phone</label>
                                    <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', optional($mainPoc)->contact_phone) }}">
                                </div>
                            </div>

                            <hr class="my-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Extra Contacts</h6>
                                <button type="button" class="btn btn-sm btn-light-primary" id="addExtraContactBtn">
                                    <i class="feather-plus me-1"></i> Add Contact
                                </button>
                            </div>
                            <div id="extraContactsContainer">
                                @foreach($user->pointOfContact as $index => $poc)
                                    <div class="row g-3 mb-3 extra-contact-row border rounded p-3">
                                        <input type="hidden" name="extra_existing_images[{{ $index }}]" value="{{ $poc->image }}">
                                        <div class="col-md-4">
                                            <label class="form-label small text-uppercase text-muted">Photo</label>
                                            @if($poc->image)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $poc->image) }}" alt="Contact photo" class="img-thumbnail" style="max-height: 80px;">
                                                </div>
                                            @endif
                                            <input type="file" name="extra_images[{{ $index }}]" class="form-control" accept="image/*">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small text-uppercase text-muted">Name</label>
                                            <input type="text" name="extra_names[{{ $index }}]" class="form-control" value="{{ old('extra_names.'.$index, $poc->contact_name) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small text-uppercase text-muted">Surname</label>
                                            <input type="text" name="extra_surnames[{{ $index }}]" class="form-control" value="{{ old('extra_surnames.'.$index, $poc->contact_surname) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small text-uppercase text-muted">Position</label>
                                            <input type="text" name="extra_positions[{{ $index }}]" class="form-control" value="{{ old('extra_positions.'.$index, $poc->contact_position) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small text-uppercase text-muted">Gender</label>
                                            <input type="text" name="extra_genders[{{ $index }}]" class="form-control" value="{{ old('extra_genders.'.$index, $poc->contact_gender) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small text-uppercase text-muted">Email</label>
                                            <input type="email" name="extra_emails[{{ $index }}]" class="form-control" value="{{ old('extra_emails.'.$index, $poc->contact_email) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small text-uppercase text-muted">Phone</label>
                                            <input type="text" name="extra_phones[{{ $index }}]" class="form-control" value="{{ old('extra_phones.'.$index, $poc->contact_phone) }}">
                                        </div>
                                        <div class="col-md-8 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger remove-extra-contact">Remove Contact</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary"><i class="feather-image me-2"></i>Appearance</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <label class="form-label small text-uppercase text-muted">Company Logo</label>
                                    @if(optional($appearance)->company_logo)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $appearance->company_logo) }}" alt="Company logo" class="img-thumbnail" style="max-height: 120px;">
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" name="remove_company_logo" value="1" id="remove_company_logo">
                                                <label class="form-check-label" for="remove_company_logo">Remove logo</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="company_logo" class="form-control" accept="image/*">
                                    <small class="text-muted">Square images larger than 256x256px recommended.</small>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label small text-uppercase text-muted">Cover Image</label>
                                    @if(optional($appearance)->company_cover_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $appearance->company_cover_image) }}" alt="Cover image" class="img-thumbnail" style="max-height: 120px;">
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" name="remove_cover_image" value="1" id="remove_cover_image">
                                                <label class="form-check-label" for="remove_cover_image">Remove cover</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Images larger than 1024x768px recommended.</small>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label small text-uppercase text-muted d-block">Display Promotional Banner?</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="promo_banner" value="yes" id="promo_banner_yes"
                                                {{ $promoBannerYes ? 'checked' : '' }}>
                                            <label class="form-check-label" for="promo_banner_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="promo_banner" value="no" id="promo_banner_no"
                                                {{ ! $promoBannerYes ? 'checked' : '' }}>
                                            <label class="form-check-label" for="promo_banner_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label small text-uppercase text-muted">Promotional Banner (Desktop)</label>
                                    @if(optional($appearance)->promotional_banner)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $appearance->promotional_banner) }}" alt="Promo banner" class="img-thumbnail" style="max-height: 120px;">
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" name="remove_promo_banner_image" value="1" id="remove_promo_banner_image">
                                                <label class="form-check-label" for="remove_promo_banner_image">Remove banner</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="promo_banner_image" class="form-control" accept="image/*">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label small text-uppercase text-muted">Promotional Banner (Mobile)</label>
                                    @if(optional($appearance)->promotional_banner_mobile)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $appearance->promotional_banner_mobile) }}" alt="Mobile promo banner" class="img-thumbnail" style="max-height: 120px;">
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" name="remove_promo_banner_image_mobile" value="1" id="remove_promo_banner_image_mobile">
                                                <label class="form-check-label" for="remove_promo_banner_image_mobile">Remove mobile banner</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="promo_banner_image_mobile" class="form-control" accept="image/*">
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label small text-uppercase text-muted">Promotional Banner Link</label>
                                    <input type="text" name="promo_banner_link" class="form-control" value="{{ old('promo_banner_link', optional($appearance)->promotional_banner_link) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<template id="extraAddressTemplate">
    <div class="row g-3 mb-3 extra-address-row border rounded p-3">
        <div class="col-12">
            <label class="form-label small text-uppercase text-muted">Address</label>
            <input type="text" name="extra_addresses[]" class="form-control">
        </div>
        <div class="col-md-5">
            <label class="form-label small text-uppercase text-muted">Maps URL</label>
            <input type="url" name="extra_map_urls[]" class="form-control">
        </div>
        <div class="col-md-5">
            <label class="form-label small text-uppercase text-muted">Country</label>
            <select name="extra_countries[]" class="form-select">
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-sm btn-danger remove-extra-address w-100">Remove</button>
        </div>
    </div>
</template>

<template id="customLinkTemplate">
    <div class="row g-3 mb-3 custom-link-row border rounded p-3">
        <div class="col-md-5">
            <label class="form-label small text-uppercase text-muted">Caption (max 12)</label>
            <input type="text" name="custom_link_captions[]" class="form-control" maxlength="12">
        </div>
        <div class="col-md-5">
            <label class="form-label small text-uppercase text-muted">URL</label>
            <input type="url" name="custom_link_urls[]" class="form-control" placeholder="https://">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-sm btn-danger remove-custom-link w-100">Remove</button>
        </div>
    </div>
</template>

<template id="extraContactTemplate">
    <div class="row g-3 mb-3 extra-contact-row border rounded p-3">
        <div class="col-md-4">
            <label class="form-label small text-uppercase text-muted">Photo</label>
            <input type="file" name="extra_images[__INDEX__]" class="form-control extra-image-input" accept="image/*">
        </div>
        <div class="col-md-4">
            <label class="form-label small text-uppercase text-muted">Name</label>
            <input type="text" name="extra_names[__INDEX__]" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label small text-uppercase text-muted">Surname</label>
            <input type="text" name="extra_surnames[__INDEX__]" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label small text-uppercase text-muted">Position</label>
            <input type="text" name="extra_positions[__INDEX__]" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label small text-uppercase text-muted">Gender</label>
            <input type="text" name="extra_genders[__INDEX__]" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label small text-uppercase text-muted">Email</label>
            <input type="email" name="extra_emails[__INDEX__]" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label small text-uppercase text-muted">Phone</label>
            <input type="text" name="extra_phones[__INDEX__]" class="form-control">
        </div>
        <div class="col-md-8 d-flex align-items-end">
            <button type="button" class="btn btn-sm btn-danger remove-extra-contact">Remove Contact</button>
        </div>
    </div>
</template>

<script>
let extraContactIndex = {{ max($user->pointOfContact->count(), count(old('extra_names', []))) }};

document.getElementById('addExtraAddressBtn')?.addEventListener('click', function () {
    const template = document.getElementById('extraAddressTemplate');
    if (!template) return;
    document.getElementById('extraAddressesContainer').appendChild(template.content.cloneNode(true));
});

document.getElementById('addCustomLinkBtn')?.addEventListener('click', function () {
    const container = document.getElementById('customLinksContainer');
    const template = document.getElementById('customLinkTemplate');
    if (!container || !template) return;
    if (container.querySelectorAll('.custom-link-row').length >= 10) {
        alert('You can add up to 10 custom links.');
        return;
    }
    container.appendChild(template.content.cloneNode(true));
});

document.getElementById('addExtraContactBtn')?.addEventListener('click', function () {
    const container = document.getElementById('extraContactsContainer');
    const template = document.getElementById('extraContactTemplate');
    if (!container || !template) return;
    const html = template.innerHTML.replaceAll('__INDEX__', String(extraContactIndex++));
    const wrapper = document.createElement('div');
    wrapper.innerHTML = html.trim();
    container.appendChild(wrapper.firstElementChild);
});

document.addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-extra-address')) {
        event.target.closest('.extra-address-row')?.remove();
    }
    if (event.target.classList.contains('remove-custom-link')) {
        event.target.closest('.custom-link-row')?.remove();
    }
    if (event.target.classList.contains('remove-extra-contact')) {
        event.target.closest('.extra-contact-row')?.remove();
    }
});
</script>
@endsection
