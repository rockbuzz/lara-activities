@extends('layouts.admin')

@section('content-header')
    <h1>Atividades de Recursos</h1>
    @component('layouts.includes.admin.breadcrum')
        <li class="active">
            <a><i class="{{ config('style.icons.resources.activities-resources') }}"></i>Atividades de Recursos</a>
        </li>
    @endcomponent
@endsection

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Atividades de Recursos Registradas</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Recurso</th>
                        <th>Acão</th>
                        <th>Atualizado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>{{ $activity->causer()->isNotEmpty() ? $activity->causer->email : 'removido'}}</td>
                            <td>{{ ltrim(strrchr($activity->subject_type, "\\"), "\\") . ': ' . $activity->subject->id }}</td>
                            <td>{{ $activity->type }}</td>
                            <td>{{ $activity->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4">Nenhuma atividade cadastrada até o momento.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @if($activities instanceof \Illuminate\Pagination\LengthAwarePaginator )
                    {{ $activities->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection