@extends('admin.layouts.admin-layout')

@section('page-content')
<div class="nxl-content">
    <form action="{{ !empty($experience->encrypted_id ?? null) ? route('admin.edit.experience', $experience->encrypted_id) : route('admin.add.experience') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="page-header sticky-top">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ $currentPageName ?? 'Experience' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route($allData ?? 'admin.manage_experiences') }}">All Experiences</a></li>
                    <li class="breadcrumb-item">{{ !empty($experience->encrypted_id) ? 'Edit' : 'Add' }}</li>
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
                <div class="card-header"><h6 class="mb-0">Listing Card <small class="text-muted">(shown on /experiences)</small></h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title', $experience->title ?? '') }}" required></div>
                    <div class="col-md-6"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="{{ old('slug', $experience->slug ?? '') }}" placeholder="auto-generated from title"></div>
                    <div class="col-md-3"><label class="form-label">Season Tag</label><input type="text" name="season_tag" class="form-control" value="{{ old('season_tag', $experience->season_tag ?? '') }}" placeholder="Summer"></div>
                    <div class="col-md-3"><label class="form-label">Season Style</label><select name="season_style" class="form-select">
                        @foreach(['summer' => 'Summer', 'winter' => 'Winter', 'all' => 'All Year', 'night' => 'Nights'] as $val => $label)
                        <option value="{{ $val }}" {{ old('season_style', $experience->season_style ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select></div>
                    <div class="col-md-3"><label class="form-label">Months</label><input type="text" name="months" class="form-control" value="{{ old('months', $experience->months ?? '') }}" placeholder="Apr — Jun"></div>
                    <div class="col-md-3"><label class="form-label">Temperature</label><input type="text" name="temperature" class="form-control" value="{{ old('temperature', $experience->temperature ?? '') }}" placeholder="12°c — 22°c"></div>
                    <div class="col-md-12"><label class="form-label">Listing Description</label><textarea name="listing_description" class="form-control" rows="4">{{ old('listing_description', isset($experience) ? htmlspecialchars_decode($experience->listing_description ?? '') : '') }}</textarea></div>
                    <div class="col-md-6"><label class="form-label">Listing Image</label><input type="file" name="listing_image" class="form-control" accept="image/*">@if(!empty($experience->listing_image))<img src="{{ asset($experience->listing_image) }}" class="mt-2 rounded" width="120">@endif</div>
                    <div class="col-md-6"><label class="form-label">Card Link Text</label><input type="text" name="link_text" class="form-control" value="{{ old('link_text', $experience->link_text ?? 'Explore') }}" placeholder="Explore Summer"></div>
                    <div class="col-md-12"><label class="form-label">Highlights <small class="text-muted">(one per line)</small></label><textarea name="highlights" class="form-control" rows="4" placeholder="Forest Treks&#10;Nature Walks">@if(!empty($experience->highlights)){{ implode("\n", $experience->highlights) }}@endif</textarea></div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Detail Page Hero</h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Hero Subtitle</label><input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $experience->hero_subtitle ?? 'Experiences') }}"></div>
                    <div class="col-md-6"><label class="form-label">Hero Image</label><input type="file" name="hero_image" class="form-control" accept="image/*">@if(!empty($experience->hero_image))<img src="{{ asset($experience->hero_image) }}" class="mt-2 rounded" width="120">@endif</div>
                    <div class="col-md-12"><label class="form-label">Hero Description</label><textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', isset($experience) ? htmlspecialchars_decode($experience->hero_description ?? '') : '') }}</textarea></div>
                </div>
            </div>

            @if(!empty($experience->encrypted_id))
                @include('admin.partials.experience-detail-sections', ['sections' => $sections ?? collect()])
            @else
                <div class="alert alert-info">Save basic details first — then you can edit all detail page sections on this same form.</div>
            @endif

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">SEO & Status</h6></div>
                <div class="card-body row g-3">
                    <div class="col-md-3"><label class="form-label">List Order</label><input type="number" name="position_order" class="form-control" min="1" value="{{ old('position_order', $experience->position_order ?? '') }}" placeholder="Auto"></div>
                    <div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" {{ old('status', $experience->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option><option value="inactive" {{ old('status', $experience->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option></select></div>
                    <div class="col-md-6"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $experience->meta_title ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Meta Keywords</label><input type="text" name="meta_keyword" class="form-control" value="{{ old('meta_keyword', $experience->meta_keyword ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', isset($experience) ? htmlspecialchars_decode($experience->meta_description ?? '') : '') }}</textarea></div>
                </div>
            </div>
        </div>
    </form>
</div>
@if(!empty($experience->encrypted_id))
<script src="{{ asset('js/accommodation-admin.js') }}"></script>
@endif
@endsection
