@extends('admin.layout.app', [ 'pageTitle' => __('Event Label Management')])
@include('admin.layout.plugins.dataTable')

@section('content')

    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                Event Labels
            </h3>
            <div class="card-tools">
                <a href="{{route('event_label.create')}}"><button type="button" class="btn btn-block btn-primary">Add New Event Label</button></a>
            </div>
        </div>
        <div class="card-body">

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

            <table id="data_table1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Subtitle') }}</th>
                    <th>{{ __('Desc') }}</th>
                    <th>{{ __('Cover Picture') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event_labels as $event_label)
                    <tr>
                        <td>
                            {{ $event_label->name }}
                        </td>
                        <td>
                            {{ $event_label->subtitle  }}
                        </td>
                        <td>
                            {{ $event_label->desc }}
                        </td>
                        <td>
                            @if($event_label->cover_picture_url != null)
                                <a href="{{ $event_label->cover_picture_url }}"> {{ $event_label->picture }} </a>
                            @endif

                        </td>
                        <td class="td-actions text-right">
                            <form action="{{ route('event_label.destroy', $event_label) }}" method="post">
                                @csrf
                                @method('delete')

                                <a rel="tooltip" class="btn btn-info" href="{{ route('event_label.show', $event_label) }}" data-original-title="" title="">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a rel="tooltip" class="btn btn-success" href="{{ route('event_label.edit', $event_label) }}" data-original-title="" title="">
                                    <i class="fas fa-edit"></i>
                                    <div class="ripple-container"></div>
                                </a>
                                @if($event_label->events->count()==0)
                                <button type="button" class="btn btn-danger" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this Game?") }}') ? this.parentElement.submit() : ''">
                                    <i class="fa fa-times"></i>
                                </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

@endsection