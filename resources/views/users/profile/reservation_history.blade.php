@extends('users.layout.app', [ 'pageTitle' => __('تاریخچه رزروها')])
@include('admin.layout.plugins.dataTable')

@section('content')
    <style>
        table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable td:last-child, table.table-bordered.dataTable td:last-child {
            border-right-width: 1px;
        }
    </style>
    @if (session('status'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                تاریخچه رزروها
            </h3>
            <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#reserve" data-toggle="tab">فعال</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#event" data-toggle="tab">گذشته</a>
                    </li>
                </ul>
            </div>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active table-responsive" id="reserve"
                     style="position: relative;">
                    <table id="data_table1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>نوع</th>
                            <th>کد پیگیری</th>
                            <th>تعداد</th>
                            <th>وضعیت</th>
                            <th>محل/نام ایونت</th>
                            <th>تاریخ</th>
                            <th>ساعت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($data['open'] as $open)
                                @if($open['type'] == 'reserve')
                                    <tr>
                                        <td> رزرو {{ (!empty($open['data']['food'])) ? "(با غذا)" :'' }}</td>
                                        <td>{{$open['data']['reservation_id'] }}</td>
                                        <td>{{$open['data']['number'] }}</td>
                                        <td>فعال</td>
                                        <td>{{$open['data']['time_place_data']['location'] }}</td>
                                        <td>{{$open['data']['time_place_data']['date'] }}</td>
                                        <td>{{$open['data']['time_place_data']['time'] }}</td>
                                        <td> <a rel="tooltip" class="btn btn-success" href="{{route('user.reserve.edit',$open['data']['reservation_id'])}}" data-original-title="" title="">
                                                <i class="fas fa-edit"></i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-original-title="" title="" onclick="confirm('{{ __("آیا مایل به کنسل کردن رزرو خود هستید؟") }}') ? location.href='{{route('user.reserve.cancel',$open['data']['reservation_id'])}}' : ''">
                                                <i class="fa fa-times"></i>
                                            </button> </td>
                                    </tr>
                                @endif

                                @if($open['type'] == 'event')
                                    <tr>
                                        <td> ایونت </td>
                                        <td>{{$open['data']['registration_id'] }}</td>
                                        <td>{{$open['data']['number'] }}</td>
                                        <td>فعال</td>
                                        <td>{{$open['data']['event_data']['title'] }}</td>
                                        <td>{{$open['data']['event_data']['date'] }}</td>
                                        <td>{{$open['data']['event_data']['time']}} </td>
                                        <td><button type="button" class="btn btn-danger" data-original-title="" title="" onclick="confirm('{{ __("آیا مایل به کنسل کردن ثبت نام خود هستید؟") }}') ? location.href='google.com' : ''">
                                                <i class="fa fa-times"></i>
                                            </button> </td></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="chart tab-pane" id="event" style="position: relative;">
                    <table id="data_table2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>نوع</th>
                            <th>کد پیگیری</th>
                            <th>تعداد</th>
                            <th>وضعیت</th>
                            <th>محل/نام ایونت</th>
                            <th>تاریخ</th>
                            <th>ساعت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['close'] as $open)
                            @if($open['type'] == 'reserve')
                                <tr>
                                    <td> رزرو </td>
                                    <td>{{$open['data']['reservation_id'] }}</td>
                                    <td>{{$open['data']['number'] }}</td>
                                    <td>{{ ($open['data']['state'] == -1) ? 'کنسل شده' : 'گذشته'   }}</td>
                                    <td>{{$open['data']['time_place_data']['location'] }}</td>
                                    <td>{{$open['data']['time_place_data']['date'] }}</td>
                                    <td>{{$open['data']['time_place_data']['time'] }}</td>

                                </tr>
                            @endif

                            @if($open['type'] == 'event')
                                <tr>
                                    <td> ایونت </td>
                                    <td>{{$open['data']['registration_id'] }}</td>
                                    <td>{{$open['data']['number'] }}</td>
                                    <td>گذشته</td>
                                    <td>{{$open['data']['event_data']['title'] }}</td>
                                    <td>{{$open['data']['event_data']['date'] }}</td>
                                    <td>{{$open['data']['event_data']['time']}} </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.card-body -->
    </div>
@endsection