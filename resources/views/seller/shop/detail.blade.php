@extends('seller.layouts.app')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Shop Settings')}}
                <span class="ml-3 fs-13">(<a href="{{ route('shop.visit', $shop->slug) }}" class="btn btn-link btn-sm px-0" target="_blank">{{ translate('Visit Shop')}} <i class="fa fa-arrow-right"></i></a>)</span>
            </h1>
        </div>
      </div>
    </div>

    <!-- Basic Info -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Basic Info') }}</h5>
        </div>
        <div class="card-body">
            <form class="" action="{{ route('seller.shop.update') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                @csrf
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shop Name') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Shop Name')}}" name="name" value="{{ $shop->name }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Shop Logo') }}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="logo" value="{{ $shop->logo }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Shop Phone') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Phone')}}" name="phone" value="{{ $shop->phone }}" required>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shop Address') }} <span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Address')}}" name="address" value="{{ $shop->address }}" required>
                    </div>
                </div>
                
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Meta Title') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Meta Title')}}" name="meta_title" value="{{ $shop->meta_title }}" required>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Meta Description') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <textarea  name="meta_description" rows="3" class="form-control mb-3" required>{{ $shop->meta_description }}</textarea>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    

    <!-- Banner Settings -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Banner Settings') }}</h5>
        </div>
        <div class="card-body">
            <form class="" action="{{ route('seller.shop.update') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                @csrf
                <!-- Top Banner -->
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Top Banner') }} (1920x360)</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="top_banner" value="{{ $shop->top_banner }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                        <small class="text-muted">{{ translate('We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.') }}</small>
                    </div>
                </div>
                <!-- Slider Banners -->
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Slider Banners') }} (1500x450)</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="sliders" value="{{ $shop->sliders }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                        <small class="text-muted">{{ translate('We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.') }}</small>
                    </div>
                </div>
                <!-- Banner Full width 1 -->
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Banner Full width 1') }}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="banner_full_width_1" value="{{ $shop->banner_full_width_1 }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <!-- Banners half width -->
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Banners half width') }} ({{ translate('2 Equal Banners') }})</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="banners_half_width" value="{{ $shop->banners_half_width }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <!-- Banner Full width 2 -->
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Banner Full width 2') }}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="banner_full_width_2" value="{{ $shop->banner_full_width_2 }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <!-- Save Button -->
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    

@endsection

@section('script')


@endsection