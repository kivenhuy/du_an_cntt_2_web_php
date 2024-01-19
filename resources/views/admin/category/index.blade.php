@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Category') }}</h5>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Name  & hit Enter') }}">
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
                            <th>{{ translate('Cateogry Icon') }}</th>
                            <th>{{ translate('Cateogry Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Category Slug') }}</th>
                            <th class="text-right">{{ translate('Action') }}</th>
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