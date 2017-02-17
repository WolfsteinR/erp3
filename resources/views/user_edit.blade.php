@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h1>Список пользователей тестовой ERP</h1>
            <a href="/admin/users">Список пользователей</a>

            <form method="post" action="user-edit/{{$user->id}}">
                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" name="first_name" id="exampleInputName" placeholder="{{$user->first_name}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputName">Family</label>
                    <input type="text" class="form-control" name="last_name" id="exampleInputName" placeholder="{{$user->last_name}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputRule">Выберите роль</label>
                    <select class="form-control" name="rule" id="exampleInputRule">
                        <option>Выберите роль</option>
                        <option>admin</option>
                        <option>manager</option>
                        <option>client</option>
                        <option>specialist</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Пароль</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="active" @if($user->active == 1)checked @endif> Статус (активный/не активный)
                    </label>
                </div>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-default">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection