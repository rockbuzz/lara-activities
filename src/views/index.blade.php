@extends(config('activities.views.layout'))

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">{{ ucfirst(trans('activities::views.activities')) }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-9">
                    
                </div>
                <div class="col-md-3">
                <form action="{{ url()->current() }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="ID {{ ucfirst(trans('activities::views.table.resource')) }}" class="form-control">
                                <span class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat">
                                    <span class="fa fa-search"></span>
                                </button>
                                </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ ucfirst(trans('activities::views.table.user')) }}</th>
                        <th>{{ ucfirst(trans('activities::views.table.resource')) }}: id</th>
                        <th>{{ ucfirst(trans('activities::views.table.action')) }}</th>
                        <th>{{ ucfirst(trans('activities::views.table.in')) }}</th>
                        <th>{{ ucfirst(trans('activities::views.table.data')) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>{{ $activity->causer ? $activity->causer->email : '--'}}</td>
                            <td>{{ ltrim(strrchr($activity->subject_type, "\\"), "\\") . ': ' . $activity->subject->id }}</td>
                            <td>{{ $activity->type }}</td>
                            <td>{{ $activity->updated_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                            @if($activity->changes)
                                <a href="{{ route('admin.activities', $activity) }}">
                                    {{ ucfirst(trans('activities::views.table.data')) }}
                                </a>
                            @else
                                --
                            @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">--</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if($activities instanceof \Illuminate\Pagination\LengthAwarePaginator )
                    {{ $activities->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection