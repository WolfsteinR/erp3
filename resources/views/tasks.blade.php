@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Список задач</h1>

                @if (!$tasks->count())
                    <p><strong>Задачи отсутствуют</strong></p>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Website</td>
                            <td>Описание</td>
                            <td>Дата создания</td>
                            <td>Приоритет</td>
                            <td>Статус</td>
                            @if(Auth::user()->role == 'manager')
                                <td>Исполнитель</td>
                            @endif
                            @if(Auth::user()->role == 'manager' || Auth::user()->role == 'specialist')
                                <td>Лимит</td>
                                <td>Потрачено</td>
                            @endif
                            <td>Действие</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr class="@if($task->priority == 'high')danger @elseif($task->priority == 'medium')success @elseif($task->priority == 'low')active @endif">
                                <td>{{$task->website}}</td>
                                <td>{{str_limit($task->body, $limit = 30, $end = '...')}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>@if($task->priority == 'high')Высокий @elseif($task->priority == 'medium')Средний @elseif($task->priority == 'low')Низкий @endif</td>
                                <td>@if($task->status_work == 'waiting')В очереди @elseif($task->status_work == 'in_work')В работе @elseif($task->status_work == 'stop')Приостановлена @elseif($task->status_work == 'job_done')Выполнена @endif</td>
                                @if(Auth::user()->role == 'manager')
                                    <td>@if($task->name != ''){{$task->name}}@endif</td>
                                    <td>{{$task->time_limit}}</td>
                                    <td>{{$task->time}}</td>
                                    <td><a href="/admin/update-task/{{$task->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a></td>
                                @endif
                                @if(Auth::user()->role == 'specialist')
                                    <td>{{$task->time_limit}}</td>
                                    <td>{{$task->time}}</td>
                                @endif
                                @if(Auth::user()->role == 'specialist')
                                    <td><a href="/admin/show-task/{{$task->id}}"><i class="fa fa-eye" aria-hidden="true"></i> Посмотреть задачу</a></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
@endsection