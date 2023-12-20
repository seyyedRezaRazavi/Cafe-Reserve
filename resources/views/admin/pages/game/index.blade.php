@extends('admin.layout.app', [ 'pageTitle' => __('Game Management')])
@include('admin.layout.plugins.dataTable')


@section('content')

    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                Games
            </h3>
            <div class="card-tools">
                <a href="{{route('games.create')}}"><button type="button" class="btn btn-block btn-primary">Add New Game</button></a>
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
                        <th>{{ __('Cost') }}</th>
                        <th>{{ __('Number Of Game Board') }}</th>
                        <th>{{ __('Cover Picture') }}</th>
                        <th class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($games as $game)
                    <tr>
                        <td>
                            {{ $game->name }}
                        </td>
                        <td>
                            {{ number_format($game->cost)  }}
                        </td>
                        <td>
                            {{ $game->tedad_safhe }}
                        </td>
                        <td>
                            @if($game->cover_picture_url != null)
                                <a href="{{ $game->cover_picture_url }}"> {{ $game->cover_picture }} </a>
                            @endif

                        </td>
                        <td class="td-actions text-right">
                            <form action="{{ route('games.destroy', $game) }}" method="post">
                                @csrf
                                @method('delete')

                                <a rel="tooltip" class="btn btn-success" href="{{ route('games.edit', $game) }}" data-original-title="" title="">
                                    <i class="fas fa-edit"></i>
                                    <div class="ripple-container"></div>
                                </a>
                                <button type="button" class="btn btn-danger" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this Game?") }}') ? this.parentElement.submit() : ''">
                                    <i class="fa fa-times"></i>
                                </button>
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


