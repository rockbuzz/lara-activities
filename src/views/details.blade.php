@extends(config('activities.views.layout'))

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ ucfirst(trans('activities::views.activity')) }} #{{ $activity->id }}
            </h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ ucfirst(trans('activities::views.before')) }}</th>
                        <th>{{ ucfirst(trans('activities::views.after')) }}</th>
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