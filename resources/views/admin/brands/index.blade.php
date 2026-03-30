@extends('admin.layouts.app')
@section('content')

<div class="card">
    <div class="col">
        <div class="mar-all mb-2" style="text-align: end;">
            <a href="{{ route('admin.brands.create') }}">
                <button class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Thêm thương hiệu</button>
            </a>
        </div>
    </div>
</div>

<div class="card">
    <form id="search_form" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">Thương hiệu</h5>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Tìm tên thương hiệu & nhấn Enter">
                </div>
            </div>
        </div>
    </form>

    <div class="card-body p-3">
        @if($brands->count() > 0)
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Logo</th>
                        <th>Tên thương hiệu</th>
                        <th data-breakpoints="lg">Slug</th>
                        <th data-breakpoints="lg">Số sản phẩm</th>
                        <th class="text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $key => $brand)
                        <tr>
                            <td>{{ $brands->firstItem() + $key }}</td>
                            <td>
                                @if($brand->logo)
                                    <img src="{{ uploaded_asset($brand->logo) }}" alt="{{ $brand->name }}"
                                         style="width:60px;height:60px;object-fit:contain;border:1px solid #eee;border-radius:4px;">
                                @else
                                    <div style="width:60px;height:60px;background:#f5f5f5;border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                        <i class="fa fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $brand->name }}</strong></td>
                            <td><code>{{ $brand->slug }}</code></td>
                            <td>{{ $brand->products_count ?? $brand->products()->count() }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                   class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                   title="Chỉnh sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Xoá thương hiệu này?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Xoá">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination mt-3">
                {{ $brands->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fa fa-tag fa-3x mb-3 d-block"></i>
                Chưa có thương hiệu nào.
            </div>
        @endif
    </div>
</div>

@endsection

@section('script')
<script>
    function sort_orders(el) { $('#search_form').submit(); }
</script>
@endsection
