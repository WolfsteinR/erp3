@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Список всех задач</h1>

                @if (!$tasks->count())
                    <p><strong>Задачи отсутствуют</strong></p>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Имя</td>
                            <td>Website</td>
                            <td>Дата создания</td>
                            @if(Auth::user()->role == 'manager')
                                <td>Исполнитель</td>
                            @endif
                            <td>Редактировать</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr class="@if($task->priority == 'medium')success @elseif($task->priority == 'high')danger @endif">
                                <td>{{$task->title}}</td>
                                <td>{{$task->website}}</td>
                                <td>{{$task->created_at}}</td>
                                @if(Auth::user()->role == 'manager')
                                    <td>@if($task->name != ''){{$task->name}}@endif</td>
                                    <td><a href="/admin/update-task/{{$task->id}}">Редактировать</a></td>
                                @endif
                                @if(Auth::user()->role == 'specialist')
                                    <td><a href="/admin/show-task/{{$task->id}}">Посмотреть задачу</a></td>
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