@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <form
            action="{{ !empty($category->encrypted_id) ? route('admin.edit.gallery_category', $category->encrypted_id) : route('admin.add.gallery_category') }}"
            method="POST">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Gallery Category</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.manage_gallery_categories') }}">All Categories</a></li>
                        <li class="breadcrumb-item">Create/Edit</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="{{ route('admin.manage_gallery_categories') }}" class="page-header-right-close-toggle">
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
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter category name"
                                        value="{{ !empty($category->encrypted_id) ? $category->name : old('name') }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" placeholder="Auto-generated from name if empty"
                                        value="{{ !empty($category->encrypted_id) ? $category->slug : old('slug') }}" />
                                    @error('slug')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Show Header <span class="text-danger">*</span></label>
                                        <select class="form-select" name="show_header">
                                            <option value="1" {{ (!empty($category->encrypted_id) ? $category->show_header : old('show_header', 1)) == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ (!empty($category->encrypted_id) ? $category->show_header : old('show_header')) == 0 ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('show_header')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" name="is_active">
                                            <option value="1" {{ (!empty($category->encrypted_id) ? $category->is_active : old('is_active', 1)) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ (!empty($category->encrypted_id) ? $category->is_active : old('is_active')) == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('is_active')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if (!empty($category->encrypted_id))
                                        <div class="col-md-4 mb-4">
                                            <label class="form-label">Position</label>
                                            <input type="number" class="form-control" name="position_order"
                                                value="{{ $category->position_order ?? old('position_order') }}" placeholder="Order" />
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
