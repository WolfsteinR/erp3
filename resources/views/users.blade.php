@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Список пользователей тестовой ERP</h1>

            @if (!$users->count())
                There is no post till now. Login and write a new post now!!!
            @else
            <table class="table">
                <thead>
                <tr>
                    <td>Имя</td>
                    <td>Email</td>
                    <td>Роль</td>
                    <td>Статус (активен/не активен)</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr @if ($user->active == 1) class="success" @else class="danger" @endif >
                        <td>
                            <p>{{$user->name}}</p>
                        </td>
                        <td>
                            <p>{{$user->email}}</p>
                        </td>
                        <td>
                            <p>{{$user->role}}</p>
                        </td>
                        <td>
                            <p>{{$user->active}}</p>
                        </td>
                        <td>
                            <a href="/admin/users/{{$user->id}}">Изменить</a>
                        </td>
                        <td>
                            <a href="/admin/users/{{$user->id}}">Удалить</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection