@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!--
                Добавить кнопку с изменением статуса заказа и поле для комментирования. Выводить прикрепленные файлы чтоб их мог скачать исполнитель.
                -->

                <div class="form-group">
                    <p><strong>Title</strong></p>
                    <p>@if(!empty($task)){{$task->title}}@endif</p>
                </div>
                <div class="form-group">
                    <p><strong>Website</strong></p>
                    <p>@if(!empty($task)){{$task->website}}@endif</p>
                </div>
                <div class="form-group">
                    <p><strong>Текст задачи</strong></p>
                    <div>@if(!empty($task)){{$task->body}}@endif</div>
                </div>
                <div class="form-group">
                    <p><strong>Приоритет задачи</strong></p>
                    <p>@if(!empty($task) && $task->priority == 'high') Высокий @elseif(!empty($task) && $task->priority == 'medium') Средний @elseif(!empty($task) && $task->priority == 'low') Низкий @endif</p>
                </div>

                <div class="form-group">
                    <p><strong>Время выполнения задачи</strong></p>
                    <p></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="task_logs">
                    @if(!empty($logs))
                        @foreach($logs as $log)
                            {{$log->status_work}}
                            {{$log->comment}}
                            {{$log->created_at}}
                        @endforeach
                    @endif
                    <!--
                    Тут будут логи задачи с прокруткой
                    -->
                </div>
                <form method="post" action="/admin/task-work/{{$task->id}}" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputText">Коментарий исполнителя</label>
                        <textarea name="comment" class="form-control" id="exampleInputText" cols="30" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <!-- приоритет задачи -->
                        <label for="status_work">Статус выполнения</label>
                        <select class="form-control" name="status_work">
                            <option value="in_work">На исполнении</option>
                            <option value="stop">Приостановлено</option>
                            <option value="job_done">Выполнена</option>
                        </select>
                    </div>

                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button type="submit" class="btn btn-default">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
@endsection