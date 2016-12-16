@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Добавление / редактирование задачи</h1>
                <p><a href="/admin">Назад</a></p>
                <form method="post" action="/admin/{{$link}}/{{Auth::user()->id}}">
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputName" placeholder="@if(!empty($task)) {{$task->name}} @endif" />
                    </div>
                    <div class="form-group">
                        <!-- поле с сайтом фирмы -->
                        <label for="exampleInputWebsite">Website</label>
                        <input type="text" class="form-control" name="name" id="exampleInputWebsite" placeholder="@if(!empty($company)) {{$company->website}} @endif" />
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="active" @if(!empty($task) && $task->active == 1)checked @endif> Статус (активный/не активный)
                        </label>
                    </div>
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
        </div>
    </div>
@endsection