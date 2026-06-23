@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <form action="{{ route('admin.edit.contact', $contact->encrypted_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Website Contact Information</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Manage Contact Information</li>
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
                            <button type="submit" class="btn btn-primary">
                                <i class="feather-save me-2"></i>
                                <span>Save</span>
                            </button>
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card stretch stretch-full">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label for="phone" class="form-label">Company Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            oninput="this.value = this.value.replace(/[^0-9+()\- ]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            maxlength="20" value="{{ $contact->phone }}" placeholder="Company Phone">
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="whatsapp_phone" class="form-label">WhatsApp Phone</label>
                                        <input type="text" class="form-control" id="whatsapp_phone" name="whatsapp_phone"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            maxlength="15" value="{{ $contact->whatsapp_phone }}"
                                            placeholder="WhatsApp Phone">
                                        @error('whatsapp_phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="alternate_phone" class="form-label">Company Alternate Phone</label>
                                        <input type="text" class="form-control" id="alternate_phone"
                                            name="alternate_phone"
                                            oninput="this.value = this.value.replace(/[^0-9+()\- ]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            maxlength="20" value="{{ $contact->alternate_phone }}"
                                            placeholder="Company Alternate Phone">
                                        @error('alternate_phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="mail" class="form-label">Company E-Mail</label>
                                        <input type="email" class="form-control" id="mail" name="mail"
                                            value="{{ $contact->email }}" placeholder="Company E-Mail">
                                        @error('mail')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="alternate_email" class="form-label">Company Alternate E-Mail</label>
                                        <input type="email" class="form-control" id="alternate_email"
                                            name="alternate_email" value="{{ $contact->alternate_email }}"
                                            placeholder="Company Alternate E-Mail">
                                        @error('alternate_email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="map_link_visibility" class="form-label">Google Map Link
                                            Visibility</label>
                                        <select name="map_link_visibility"
                                            onchange="change_map_link_visibility(this.value);" id="map_link_visibility"
                                            class="form-select form-select">
                                            <option value="no"
                                                {{ $contact->map_link_visibility == 'no' ? 'selected' : '' }}>NO
                                            </option>
                                            <option value="yes"
                                                {{ $contact->map_link_visibility == 'yes' ? 'selected' : '' }}>YES
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-5" id="map_link_div">
                                        <label for="map_link" class="form-label">Google Map Link</label>
                                        <input type="text" class="form-control" id="map_link" name="map_link"
                                            value="{{ htmlspecialchars_decode($contact->map_link) }}"
                                            placeholder="Enter Map Link" />
                                    </div>
                                    {{-- <div class="col-md-6 mb-5">
                                        <label for="footer_location" class="form-label">Footer Location</label>
                                        <input type="email" class="form-control" id="footer_location"
                                            name="footer_location" value="{{ $contact->footer_location }}"
                                            placeholder="Footer Location">
                                        @error('footer_location')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="col-md-12 mb-5">
                                        <label for="location" class="form-label">Company Location</label>
                                        <textarea name="location" id="location" cols="30" rows="5" class="form-control"
                                            placeholder="Enter Company Location">{!! htmlspecialchars_decode($contact->location) !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mb-5">
                                        <label for="alternate_location" class="form-label">Company Alternate
                                            Location</label>
                                        <textarea name="alternate_location" id="alternate_location" cols="30" rows="5" class="form-control"
                                            placeholder="Enter Company Alternate Location">{!! htmlspecialchars_decode($contact->alternate_location) !!}</textarea>
                                    </div>

                                     <div class="col-md-12 mb-5">
                                        <label for="title" class="form-label">Newsletter Title</label>
                                        <textarea  name="newsletter_title" id="newsletter_title" cols="30" rows="4" 
                                  class="form-control" placeholder="Enter Newsletter Title">{{ $contact->newsletter_title ?? '' }}</textarea>
                                    </div>

                                     <div class="col-md-12 mb-5">
                                        <label for="alternate_location" class="form-label">Newsletter Description</label>
                                        <textarea name="newsletter_description" id="newsletter_description" cols="30" rows="5" class="form-control"
                                            placeholder="Enter Company Alternate Location">{!! htmlspecialchars_decode($contact->newsletter_description ?? '') !!}</textarea>
                                    </div>

                                   <div class="col-md-12 mb-5">
                                        <label for="alternate_location" class="form-label">Newsletter Image</label>
                                        
                                        <!-- Existing image preview -->
                                        @if($contact->newsletter_image)
                                            <div class="mb-3">
                                                <img src="{{ asset($contact->newsletter_image) }}"  alt="Newsletter Image" class="img-fluid rounded" style="max-width: 300px; max-height: 200px;">
                                            </div>
                                        @endif

                                        <input type="file" name="newsletter_image" id="newsletter_image" class="form-control" accept="image/*">
                                    </div>
                                     <div class="col-md-12 mb-5">
                                        <label for="newsletter_success_msg" class="form-label">Newsletter Success Message</label>
                                        <textarea name="newsletter_success_msg" id="newsletter_success_msg" cols="30" rows="5" class="form-control"
                                            placeholder="Enter Newsletter Success Message">{!! htmlspecialchars_decode($contact->newsletter_success_msg) !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- [ Main Content ] end -->
    </div>
@endsection

@push('page-wise-js')
    <script>
        function change_map_link_visibility(value) {
            if (value == "yes") {
                $("#map_link_div").show();
            } else {
                $("#map_link_div").hide();
            }
            return false;
        }

        change_map_link_visibility('{{ $contact->map_link_visibility }}');
    </script>
@endpush
