@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <div class="col">
            <div class="mar-all mb-2" style=" text-align: end;">
                <a href="{{route('categories.create')}}">
                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-plus mr-1"></i>Tạo danh mục
                    </button>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">Danh mục</h5>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="Nhập tên danh mục & nhấn Enter">
                    </div>
                </div>
            </div>
        </form>

        @if (count($cate_data) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Biểu tượng</th>
                            <th>Tên danh mục</th>
                            <th data-breakpoints="lg">Mã danh mục</th>
                            <th class="text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cate_data as $key => $each_cate_data)
                            @if ($each_cate_data != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                      <img src="{{uploaded_asset($each_cate_data->icon)}}" alt="" style="width: 90px; height: 90px;">
                                  </td>
                                    <td>
                                        {{$each_cate_data->name}}
                                    </td>
                                    <td>
                                        {{$each_cate_data->slug}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $cate_data->links() }}
                </div>
            </div>
        @else
            <div class="card-body p-3 text-center text-muted py-5">
                <i class="fa fa-mortar-pestle fa-3x mb-3 d-block"></i>
                Chưa có danh mục nào.
            </div>
        @endif
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el) {
            $('#sort_orders').submit();
        }
    </script>
@endsection