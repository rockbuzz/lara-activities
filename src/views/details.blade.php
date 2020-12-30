@extends(config('activities.views.layout'))

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
                            <td>
                                <ul>
                                    @foreach($activity->changes['before'] as $key => $value)
                                    <li>{{ $key }}: {{ $value }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach($activity->changes['after'] as $key => $value)
                                    <li>{{ $key }}: {{ $value }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection