@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Список пользователей тестовой ERP</h1>

            <p><input type="text" class="form-control" ng-model="search" placeholder="Поиск"></p>
            <div ng-init='users = <?php echo $users; ?>'></div>

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
                <tr ng-repeat="user in users.data | filter : search" class="@{{user.active}}">
                    <td>
                        <p>@{{user.name}}{{--$user->name--}}</p>
                    </td>
                    <td>
                        <p>@{{user.email}}{{--$user->email--}}</p>
                    </td>
                    <td>
                        <p>@{{user.role}}{{--$user->role--}}</p>
                    </td>
                    <td>
                        <p>@{{user.active}}{{--$user->active--}}</p>
                    </td>
                    <td>
                        <a href="/admin/users/@{{user.id}}{{--$user->id--}}">Изменить</a>
                    </td>
                    <td>
                        <a href="/admin/users/@{{user.id}}{{--$user->id--}}">Удалить</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection