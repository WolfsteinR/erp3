@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Добро пожаловать в тестовую ERP</h1>
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

            <p>{{ Auth::user()->name }}</p>

            @if (Auth::user()->role == 'admin')
                <p><a href="/admin/users">Пользователи</a></p>
                <p><a href="/admin/companies">Компании</a></p>
            @endif

            @if (Auth::user()->role == 'client')
                <p><a href="/admin/create-company/{{Auth::user()->id}}">Добавить новую компанию</a></p>
                <p><a href="/admin/edit-company/{{Auth::user()->id}}">Редактировать компанию</a></p>
            @endif

        @endif
    </div>
@endsection