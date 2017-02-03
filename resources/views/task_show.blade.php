@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                Добавить кнопку с изменением статуса заказа и поле для комментирования. Выводить прикрепленные файлы чтоб их мог скачать исполнитель.
                <form method="post" action="/admin/" enctype="multipart/form-data">
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
                        <label for="exampleInputText">Коментарий исполнителя</label>
                        <textarea name="comment" class="form-control" id="exampleInputText" cols="30" rows="10"></textarea>
                    </div>

                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button type="submit" class="btn btn-default">Редактировать задачу</button>
                </form>
            </div>
        </div>
    </div>
@endsection