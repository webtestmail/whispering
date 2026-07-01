@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <form action="{{ route('admin.edit.legal', $legalPage->encrypted_id) }}" method="POST">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ $legalPage->page_name }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.manage_legal') }}">Legal Pages</a></li>
                        <li class="breadcrumb-item">Edit</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('admin.manage_legal') }}" class="btn btn-light-brand">Back</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather-save me-2"></i>
                            <span>Save</span>
                        </button>
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

                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Page Content</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label">Page</label>
                            <input type="text" class="form-control" value="{{ $legalPage->page_name }}" disabled>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title', $legalPage->title) }}" placeholder="Enter page title">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" cols="30" rows="15" class="form-control"
                                placeholder="Enter page content">{{ old('description', htmlspecialchars_decode($legalPage->description ?? '')) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="active" {{ old('status', $legalPage->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $legalPage->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">SEO</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="meta_title" class="form-label">Meta Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                value="{{ old('meta_title', $legalPage->meta_title) }}" placeholder="Enter meta title">
                            @error('meta_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="meta_keyword" class="form-label">Meta Keywords <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="meta_keyword" name="meta_keyword"
                                value="{{ old('meta_keyword', $legalPage->meta_keyword) }}" placeholder="Enter meta keywords">
                            @error('meta_keyword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label for="meta_description" class="form-label">Meta Description <span class="text-danger">*</span></label>
                            <textarea name="meta_description" id="meta_description" cols="30" rows="4" class="form-control no-editor"
                                placeholder="Enter meta description">{{ old('meta_description', htmlspecialchars_decode($legalPage->meta_description ?? '')) }}</textarea>
                            @error('meta_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('page-wise-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove('#meta_description');
        }
    });
</script>
@endpush
