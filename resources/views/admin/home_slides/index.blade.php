@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Homepage carousel') }}</h1>
            <span class="text-muted">{{ translate('Images shown in the main slider on the storefront.') }}</span>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('admin.home_slides.create') }}" class="btn btn-primary">{{ translate('Add slide') }}</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if ($slides->isEmpty())
            <p class="text-muted mb-0">{{ translate('No slides yet. The homepage will use default static images until you add slides.') }}</p>
        @else
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Image') }}</th>
                        <th>{{ translate('Link') }}</th>
                        <th>{{ translate('Sort') }}</th>
                        <th>{{ translate('Active') }}</th>
                        <th class="text-right">{{ translate('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($slides as $i => $slide)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <img src="{{ uploaded_asset($slide->photo) }}" alt="" style="max-height: 72px; max-width: 160px; object-fit: cover;"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                            </td>
                            <td style="max-width: 220px; word-break: break-all;">{{ $slide->link ?: '—' }}</td>
                            <td>{{ $slide->sort_order }}</td>
                            <td>{{ $slide->is_active ? translate('Yes') : translate('No') }}</td>
                            <td class="text-right">
                                <form action="{{ route('admin.home_slides.destroy', $slide) }}" method="post" class="d-inline" onsubmit="return confirm('{{ translate('Delete this slide?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">{{ translate('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
