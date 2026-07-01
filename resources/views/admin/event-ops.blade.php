@extends('admin.layouts.admin-layout')

@section('page-content')
<div class="nxl-content">
    <form action="{{ !empty($event->encrypted_id ?? null) ? route('admin.edit.event', $event->encrypted_id) : route('admin.add.event') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="page-header sticky-top">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ $currentPageName ?? 'Event' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route($allData ?? 'admin.manage_events') }}">All Events</a></li>
                    <li class="breadcrumb-item">{{ !empty($event->encrypted_id) ? 'Edit' : 'Add' }}</li>
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
                <div class="card-header"><h6 class="mb-0">Listing Card <small class="text-muted">(shown on /events)</small></h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title', $event->title ?? '') }}" required></div>
                    <div class="col-md-6"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="{{ old('slug', $event->slug ?? '') }}" placeholder="auto-generated from title"></div>
                    <div class="col-md-12"><label class="form-label">Listing Description</label><textarea name="listing_description" class="form-control" rows="4">{{ old('listing_description', isset($event) ? htmlspecialchars_decode($event->listing_description ?? '') : '') }}</textarea></div>
                    <div class="col-md-6"><label class="form-label">Listing Image</label><input type="file" name="listing_image" class="form-control" accept="image/*">@if(!empty($event->listing_image))<img src="{{ asset($event->listing_image) }}" class="mt-2 rounded" width="120">@endif</div>
                    <div class="col-md-6"><label class="form-label">Card Link Text</label><input type="text" name="link_text" class="form-control" value="{{ old('link_text', $event->link_text ?? 'Explore More') }}" placeholder="Explore More"></div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Detail Page Hero</h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Hero Subtitle</label><input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $event->hero_subtitle ?? 'Events & Groups') }}"></div>
                    <div class="col-md-6"><label class="form-label">Hero Image</label><input type="file" name="hero_image" class="form-control" accept="image/*">@if(!empty($event->hero_image))<img src="{{ asset($event->hero_image) }}" class="mt-2 rounded" width="120">@endif</div>
                    <div class="col-md-12"><label class="form-label">Hero Description</label><textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', isset($event) ? htmlspecialchars_decode($event->hero_description ?? '') : '') }}</textarea></div>
                </div>
            </div>

            @if(!empty($event->encrypted_id))
                @include('admin.partials.event-detail-sections', ['sections' => $sections ?? collect()])
            @else
                <div class="alert alert-info">Save basic details first — then you can edit all detail page sections on this same form.</div>
            @endif

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">SEO & Status</h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-3"><label class="form-label">List Order</label><input type="number" name="position_order" class="form-control" min="1" value="{{ old('position_order', $event->position_order ?? '') }}" placeholder="Auto"></div>
                    <div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" {{ old('status', $event->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option><option value="inactive" {{ old('status', $event->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option></select></div>
                    <div class="col-md-6"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $event->meta_title ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Meta Keywords</label><input type="text" name="meta_keyword" class="form-control" value="{{ old('meta_keyword', $event->meta_keyword ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', isset($event) ? htmlspecialchars_decode($event->meta_description ?? '') : '') }}</textarea></div>
                </div>
            </div>
        </div>
    </form>
</div>
@if(!empty($event->encrypted_id))
<script src="{{ asset('js/accommodation-admin.js') }}"></script>
@endif
@endsection
