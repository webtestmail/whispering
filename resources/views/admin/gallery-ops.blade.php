@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <form
            action="{{ !empty($gallery->encrypted_id) ? route('admin.edit.gallery', $gallery->encrypted_id) : route('admin.add.gallery') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Gallery Item</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.manage_galleries') }}">All Gallery</a></li>
                        <li class="breadcrumb-item">Create/Edit</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="{{ route('admin.manage_galleries') }}" class="page-header-right-close-toggle">
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

            <div class="main-content">
                <div class="row">
                    <div class="col-xl-12">
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
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter title"
                                        value="{{ !empty($gallery->encrypted_id) ? $gallery->title : old('title') }}" />
                                    @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" placeholder="Auto-generated from title if empty"
                                        value="{{ !empty($gallery->encrypted_id) ? $gallery->slug : old('slug') }}" />
                                    @error('slug')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control" name="short_description" rows="3"
                                        placeholder="Enter short description">{{ !empty($gallery->encrypted_id) ? htmlspecialchars_decode($gallery->short_description) : old('short_description') }}</textarea>
                                    @error('short_description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" name="gallery_category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->encrypted_id }}"
                                                {{ (!empty($gallery->encrypted_id) && $gallery->gallery_category_id == $category->id) || old('gallery_category') == $category->encrypted_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gallery_category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Image @if (empty($gallery->encrypted_id))<span class="text-danger">*</span>@endif</label>
                                    @if (!empty($gallery->encrypted_id) && !empty($gallery->image))
                                        <div class="my-3">
                                            <img src="{{ asset($gallery->image) }}" class="img-fluid rounded" alt="Gallery image" style="max-height:120px;" />
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" name="image" accept="image/*" />
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Featured <span class="text-danger">*</span></label>
                                        <select class="form-select" name="is_feature">
                                            <option value="1" {{ (!empty($gallery->encrypted_id) ? $gallery->is_feature : old('is_feature', 0)) == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ (!empty($gallery->encrypted_id) ? $gallery->is_feature : old('is_feature', 0)) == 0 ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('is_feature')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" name="is_active">
                                            <option value="1" {{ (!empty($gallery->encrypted_id) ? $gallery->is_active : old('is_active', 1)) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ (!empty($gallery->encrypted_id) ? $gallery->is_active : old('is_active')) == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('is_active')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if (!empty($gallery->encrypted_id))
                                        <div class="col-md-4 mb-4">
                                            <label class="form-label">Position</label>
                                            <input type="number" class="form-control" name="position_order"
                                                value="{{ $gallery->position_order ?? old('position_order') }}" placeholder="Order" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
