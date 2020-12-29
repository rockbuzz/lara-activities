@extends(config('activities.views.layout'))

@section('content-header')
    <h1>Atividades de Recursos</h1>
    <ol class="breadcrumb">
        <li>
            <a href="/admin/dashboard">
                <i class="fa fa-dashboard"></i>Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/atividades">
                <i class="{{ config('style.icons.resources.activities-resources') }}"></i>Atividades
            </a>
        </li>
        <li class="active">
            <a><i class="{{ config('style.icons.resources.activities-resources') }}"></i>Atividade #{{$activity->id}}</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Atividades #{{ $activity->id }}</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Antes</th>
                        <th>Depois</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $activity->changes ? json_encode($activity->changes) : '' }}</td>
                            <td>{{ $activity->changes ? json_encode($activity->changes) : '' }}</td>
                        </tr>
                    </tbody>
                </table>
                @if($activities instanceof \Illuminate\Pagination\LengthAwarePaginator )
                    {{ $activities->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection