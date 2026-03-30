@extends('admin.layouts.app')
@section('content')

@php $isEdit = !is_null($brand); @endphp

<div class="aiz-titlebar mt-2 mb-4">
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row" style="margin-bottom:0.5rem;display:flex!important;align-items:center;">
            <div class="col-md-10">
                <h1 class="h3">{{ $isEdit ? 'Chỉnh sửa thương hiệu' : 'Thêm thương hiệu' }}</h1>
            </div>
            <div class="text-center col-md-2">
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left mr-1"></i>Quay lại
                </a>
            </div>
        </div>

        <form action="{{ $isEdit ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div class="row gutters-5">
                <div class="col-lg-8">

                    {{-- Basic info --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Thông tin thương hiệu</h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    Tên thương hiệu <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name', $brand?->name) }}"
                                           placeholder="Ví dụ: L'Oréal Paris" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Slug</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                           name="slug" id="slug_input"
                                           value="{{ old('slug', $brand?->slug) }}"
                                           placeholder="tu-dong-tao-neu-de-trong">
                                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="text-muted">Dùng trong URL: /thuong-hieu/<strong>slug</strong></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Mô tả</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="description" rows="4"
                                              placeholder="Giới thiệu ngắn về thương hiệu...">{{ old('description', $brand?->description) }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0 h6">SEO</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Meta Title</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="meta_title"
                                           value="{{ old('meta_title', $brand?->meta_title) }}"
                                           placeholder="Meta Title">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Meta Description</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="meta_description"
                                           value="{{ old('meta_description', $brand?->meta_description) }}"
                                           placeholder="Meta Description">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4">

                    {{-- Logo --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Logo thương hiệu</h5>
                        </div>
                        <div class="card-body">
                            @if($isEdit && $brand->logo)
                                <div class="mb-2 text-center">
                                    <img src="{{ uploaded_asset($brand->logo) }}" alt="Logo hiện tại"
                                         style="max-height:100px;object-fit:contain;border:1px solid #eee;padding:4px;border-radius:4px;">
                                    <div><small class="text-muted">Logo hiện tại</small></div>
                                </div>
                            @endif
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">Duyệt</div>
                                </div>
                                <div class="form-control file-amount">Chọn file</div>
                                <input type="hidden" name="logo" class="selected-files"
                                       value="{{ old('logo', $brand?->logo) }}">
                            </div>
                            <div class="file-preview box sm"></div>
                            <small class="text-muted">PNG vuông, nền trắng hoặc trong suốt (khuyến nghị 200×200).</small>
                        </div>
                    </div>

                    {{-- Banner --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Banner trang thương hiệu</h5>
                        </div>
                        <div class="card-body">
                            @if($isEdit && $brand->banner)
                                <div class="mb-2 text-center">
                                    <img src="{{ uploaded_asset($brand->banner) }}" alt="Banner hiện tại"
                                         style="max-height:80px;width:100%;object-fit:cover;border-radius:4px;">
                                    <div><small class="text-muted">Banner hiện tại</small></div>
                                </div>
                            @endif
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">Duyệt</div>
                                </div>
                                <div class="form-control file-amount">Chọn file</div>
                                <input type="hidden" name="banner" class="selected-files"
                                       value="{{ old('banner', $brand?->banner) }}">
                            </div>
                            <div class="file-preview box sm"></div>
                            <small class="text-muted">Khuyến nghị 1200×300, JPG hoặc PNG.</small>
                        </div>
                    </div>

                </div>

                <div class="col-12">
                    <div class="mar-all text-right mb-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-1"></i>{{ $isEdit ? 'Lưu thay đổi' : 'Thêm thương hiệu' }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    // Auto-generate slug from name (only when slug field is empty)
    document.getElementById('slug_input').addEventListener('focus', function () {
        this._manuallyEdited = true;
    });

    @if(!$isEdit)
    document.querySelector('[name="name"]').addEventListener('input', function () {
        var slugInput = document.getElementById('slug_input');
        if (!slugInput._manuallyEdited || slugInput.value === '') {
            slugInput._manuallyEdited = false;
            slugInput.value = this.value
                .toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/đ/g, 'd').replace(/Đ/g, 'd')
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        }
    });
    @endif
</script>
@endsection
