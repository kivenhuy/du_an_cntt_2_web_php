@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="h3">{{ translate('Add carousel slide') }}</h1>
        </div>
        <div class="col-md-4 text-md-right">
            <a href="{{ route('admin.home_slides.index') }}" class="btn btn-secondary">{{ translate('Back') }}</a>
        </div>
    </div>
</div>

<form action="{{ route('admin.home_slides.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Slide') }}</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Image') }} <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                        <input type="hidden" name="photo" class="selected-files" required>
                    </div>
                    <div class="file-preview box sm"></div>
                    <small class="text-muted">{{ translate('Wide banner recommended (e.g. 1200×460).') }}</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Link (optional)') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="link" value="{{ old('link') }}" placeholder="https://... hoặc /product/slug">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Sort order') }}</label>
                <div class="col-md-8">
                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    <small class="text-muted">{{ translate('Lower numbers appear first.') }}</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Active') }}</label>
                <div class="col-md-8">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="mar-all text-right mb-2">
        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
    </div>
</form>
@endsection
