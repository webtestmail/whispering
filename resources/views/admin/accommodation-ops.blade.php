@extends('admin.layouts.admin-layout')

@section('page-content')
<div class="nxl-content">
    <form action="{{ !empty($accommodation->encrypted_id ?? null) ? route('admin.edit.accommodation', $accommodation->encrypted_id) : route('admin.add.accommodation') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="page-header sticky-top">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ $currentPageName ?? 'Accommodation' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route($allData ?? 'admin.manage_accommodations') }}">All Accommodations</a></li>
                    <li class="breadcrumb-item">{{ !empty($accommodation->encrypted_id) ? 'Edit' : 'Add' }}</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <button type="submit" class="btn btn-primary"><i class="feather-save me-2"></i><span>Save</span></button>
            </div>
        </div>

        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Listing Card <small class="text-muted">(shown on /accommodation)</small></h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title', $accommodation->title ?? '') }}" required></div>
                    <div class="col-md-6"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="{{ old('slug', $accommodation->slug ?? '') }}" placeholder="auto-generated from title"></div>
                    <div class="col-md-4"><label class="form-label">Tag</label><input type="text" name="tag" class="form-control" value="{{ old('tag', $accommodation->tag ?? '') }}"></div>
                    <div class="col-md-4"><label class="form-label">Badge</label><input type="text" name="badge" class="form-control" value="{{ old('badge', $accommodation->badge ?? '') }}"></div>
                    <div class="col-md-4"><label class="form-label">Share Basis</label><input type="text" name="share_basis" class="form-control" value="{{ old('share_basis', $accommodation->share_basis ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Listing Description</label><textarea name="listing_description" class="form-control" rows="4">{{ old('listing_description', isset($accommodation) ? htmlspecialchars_decode($accommodation->listing_description ?? '') : '') }}</textarea></div>
                    <div class="col-md-6"><label class="form-label">Listing Image</label><input type="file" name="listing_image" class="form-control" accept="image/*">@if(!empty($accommodation->listing_image))<img src="{{ asset($accommodation->listing_image) }}" class="mt-2 rounded" width="120">@endif</div>
                    <div class="col-md-6"><label class="form-label">Reverse Layout on Listing</label><select name="reverse_layout" class="form-select"><option value="0" {{ old('reverse_layout', $accommodation->reverse_layout ?? false) ? '' : 'selected' }}>No</option><option value="1" {{ old('reverse_layout', $accommodation->reverse_layout ?? false) ? 'selected' : '' }}>Yes</option></select></div>
                    <div class="col-md-12"><label class="form-label">Amenities <small class="text-muted">(one per line)</small></label><textarea name="amenities" class="form-control" rows="4" placeholder="Attached Bath&#10;Free Wifi">@if(!empty($accommodation->amenities)){{ collect($accommodation->amenities)->pluck('label')->implode("\n") }}@endif</textarea></div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Detail Page Hero</h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Hero Subtitle</label><input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $accommodation->hero_subtitle ?? 'Accommodation') }}"></div>
                    <div class="col-md-6"><label class="form-label">Hero Image</label><input type="file" name="hero_image" class="form-control" accept="image/*">@if(!empty($accommodation->hero_image))<img src="{{ asset($accommodation->hero_image) }}" class="mt-2 rounded" width="120">@endif</div>
                    <div class="col-md-12"><label class="form-label">Hero Description</label><textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', isset($accommodation) ? htmlspecialchars_decode($accommodation->hero_description ?? '') : '') }}</textarea></div>
                    <div class="col-md-6"><label class="form-label">Button Text</label><input type="text" name="button_name" class="form-control" value="{{ old('button_name', $accommodation->button_name ?? 'Book This Stay') }}"></div>
                    <div class="col-md-6"><label class="form-label">Button Link</label><input type="text" name="button_link" class="form-control" value="{{ old('button_link', $accommodation->button_link ?? route('enquire')) }}"></div>
                </div>
            </div>

            @if(!empty($accommodation->encrypted_id))
                @include('admin.partials.accommodation-detail-sections', ['sections' => $sections ?? collect()])
            @else
                <div class="alert alert-info">Save basic details first — then you can edit all detail page sections on this same form.</div>
            @endif

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">SEO & Status</h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-3"><label class="form-label">List Order</label><input type="number" name="position_order" class="form-control" min="1" value="{{ old('position_order', $accommodation->position_order ?? '') }}" placeholder="Auto"></div>
                    <div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" {{ old('status', $accommodation->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option><option value="inactive" {{ old('status', $accommodation->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option></select></div>
                    <div class="col-md-6"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $accommodation->meta_title ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Meta Keywords</label><input type="text" name="meta_keyword" class="form-control" value="{{ old('meta_keyword', $accommodation->meta_keyword ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', isset($accommodation) ? htmlspecialchars_decode($accommodation->meta_description ?? '') : '') }}</textarea></div>
                </div>
            </div>
        </div>
    </form>
</div>
@if(!empty($accommodation->encrypted_id))
<script src="{{ asset('js/accommodation-admin.js') }}"></script>
@endif
@endsection
