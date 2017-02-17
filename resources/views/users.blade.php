@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Список пользователей</h1>

                <p><form><input type="text" class="form-control" ng-model="search" placeholder="Поиск"></form></p>


                <table class="table" ng-controller="UsersCtrl">
                    <thead>
                    <tr>
                        <td>Имя</td>
                        <td>Фамилия</td>
                        <td>Email</td>
                        <td>Роль</td>
                        <td>Статус (активен/не активен)</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="user in users | filter : search" @verbatim class="active{{ user.active }}" @endverbatim>
                        @verbatim
                        <td>
                            <p>{{ user.first_name }}</p>
                        </td>
                        @endverbatim
                        <td>
                            <p>@{{user.last_name}}</p>
                        </td>
                        <td>
                            <p>@{{user.email}}</p>
                        </td>
                        <td>
                            <p>@{{user.role}}</p>
                        </td>
                        <td>
                            <p>@{{user.active}}</p>
                        </td>
                        <td>
                            <a href="/admin/users/@{{user.id}}">Изменить</a>
                        </td>
                        <td>
                            <a href="/admin/users/@{{user.id}}">Удалить</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection