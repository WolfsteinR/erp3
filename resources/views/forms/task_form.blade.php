@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Добавление / редактирование задачи</h1>
                <p><a href="/admin">Назад</a></p>
                <form method="post" action="/admin/{{$link}}/{{Auth::user()->id}}" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName">Title</label>
                        <input type="text" class="form-control" name="name" id="exampleInputName" placeholder="@if(!empty($task)) {{$task->name}} @endif" />
                    </div>
                    <div class="form-group">
                        <!-- поле с сайтом фирмы -->
                        <label for="exampleInputWebsite">Website</label>
                        <input type="text" class="form-control" name="name" id="exampleInputWebsite" value="@if(!empty($company)) {{--$company->website--}} @endif" /><!--@if(!empty($company)) {{--$company->website--}} @endif-->
                    </div>
                    <div class="form-group">
                        <label for="exampleInputText">Текст задачи</label>
                        <textarea name="body" class="form-control" id="exampleInputText" cols="30" rows="10">@if(!empty($task)) {{$task->text}} @endif</textarea>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="active" @if(!empty($task) && $task->active == 1)checked @endif> Статус (активный/не активный)
                        </label>
                    </div>
                    <div class="form-group">
                        <!-- приоритет задачи -->
                        <label for="">Приоритет задачи</label>
                        <select class="form-control" name="priority">
                            <option value="high">Высокий</option>
                            <option value="medium">Средний</option>
                            <option value="low">Низкий</option>
                        </select>
                    </div>
                    @if(Auth::user()->role == 'manager')
                        <!-- select выбор исполнителя -->
                        <p>Добавить назначение исполнителя</p>
                    @endif
                    <div class="form-group">
                        <label for="">Потом реализовать загрузку файла</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button type="submit" class="btn btn-default">Добавить задачу</button>
                </form>

            </div>
        </div>
    </div>
@endsection