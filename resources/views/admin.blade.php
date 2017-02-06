@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--<h1>Добро пожаловать в тестовую ERP</h1>-->
            </div>
        </div>

    @if (Auth::guest())
        <!-- ФОРМА ЛОГИНА -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Форма входа</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Пароль</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Запомнить меня
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Войти
                                        </button>

                                    <!--<a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Забыли пароль?
                                </a>-->
                                        <a class="btn btn-link" href="/register">Регистрация</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else

            @if (Auth::user()->role == 'admin')
                <!--<p><a href="/admin/users">Пользователи</a></p>
                <p><a href="/admin/companies">Компании</a></p>
                <p><a href="/admin/add-manager-to-client">Добавить менеджера для клиента</a></p>-->

                <!--<p><a href="/admin/add-manager-to-company">Добавить менеджера для компании</a></p>-->
                <!--<p><a href="/admin/tasks">Список задач</a></p>-->
                <p>Установить рабочий график (время, например, с 9 до 18 и обеденный перерыв).</p>
                <p>Архив задач</p>
            @endif

            @if (Auth::user()->role == 'client')
                <p>Порядок действий</p>
                <ul>
                    <li>После активации вашего аккаунта создайте свою компанию и заполните информацию о ней</li>
                    <li>Новые задачи вы сможете создавать только после прикрепления к вам менеджера. Об этом вам придет письмо.</li>
                </ul>

                @if(empty($manager))
                    <p class="bg-danger">К вам пока не прикреплен ни один менеджер. Как только менеджер будет добавлен, вы сможете создавать новые задачи.</p>
                @endif
            @endif

        @endif
    </div>
@endsection