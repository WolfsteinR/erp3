@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>@if($link == 'update-task')Редактирование задачи @else Добавление задачи @endif</h1>
                <p><a href="/admin">Назад</a></p>
                <form method="post" action="/admin/{{$link}}/@if($link == 'create-task'){{Auth::user()->id}}@else{{$task->id}}@endif" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName">Title</label>
                        <input type="text" class="form-control" name="title" id="exampleInputName" value="@if(!empty($task)){{$task->title}}@endif" />
                    </div>
                    <div class="form-group">
                        <!-- поле с сайтом фирмы -->
                        <label for="exampleInputWebsite">Website</label>
                        <input type="text" class="form-control" name="website" id="exampleInputWebsite" value="@if(!empty($task)){{$task->website}}@endif" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputText">Текст задачи</label>
                        <textarea name="body" class="form-control" id="exampleInputText" cols="30" rows="10">@if(!empty($task)){{$task->body}}@endif</textarea>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="active" @if(!empty($task) && $task->active == 1)checked @endif> Статус (активный/не активный)
                        </label>
                    </div>
                    <div class="form-group">
                        <!-- приоритет задачи -->
                        <label for="priority">Приоритет задачи</label>
                        <select class="form-control" name="priority">
                            <option value="high" @if(!empty($task) && $task->priority == 'high') selected @endif>Высокий</option>
                            <option value="medium" @if(!empty($task) && $task->priority == 'medium') selected @endif>Средний</option>
                            <option value="low" @if(!empty($task) && $task->priority == 'low') selected @endif>Низкий</option>
                        </select>
                    </div>
                    @if(Auth::user()->role == 'manager')
                        <!-- select выбор исполнителя -->
                        @if ($specialists->count())
                            <div class="form-group">
                                <label for="spec">Выберите исполнителя</label>
                                <select class="form-control" name="spec">
                                    @foreach ($specialists as $spec)
                                        <option value="{{$spec->id}}" @if($task->spec_id == $spec->id) selected @endif>{{$spec->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endif
                    <div class="form-group">
                        <label for="">Загрузка файлов</label>
                        <input multiple="1" name="images[]" type="file">
                    </div>
                    <!-- Выводить прикрепленные файлы в режиме редактирования -->
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button type="submit" class="btn btn-default">@if($link == 'update-task')Редактировать задачу @else Добавить задачу @endif</button>
                </form>

            </div>
        </div>
    </div>
@endsection