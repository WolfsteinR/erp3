<!DOCTYPE html>
<html lang="ru" ng-app>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">

    <script src="/public/js/angular.min.js"></script>
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <header>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <ul class="nav navbar-nav">
                            @if (Auth::user())
                                @if (Auth::user()->role == 'admin')
                                    <li><a href="/admin/users">Пользователи</a></li>
                                    <li><a href="/admin/companies">Компании</a></li>
                                    <li><a href="/admin/add-manager-to-client">Добавить менеджера клиенту</a></li>
                                    <li><a href="/admin/settings">Техническая информация</a></li>
                                @endif
                                @if (Auth::user()->role == 'client')
                                    @if(empty($company))
                                        <li><a href="/admin/create-company/{{Auth::user()->id}}">Добавить компанию</a></li>
                                    @else
                                        <li><a href="/admin/edit-company/{{Auth::user()->id}}">Редактировать компанию</a></li>
                                    @endif
                                    @if(!empty($manager))
                                        <li><a href="/admin/tasks">Список задач</a></li>
                                        <li><a href="/admin/create-task">Создать задачу</a></li>
                                    @endif
                                @endif
                                @if (Auth::user()->role == 'manager')
                                    <li><a href="/admin/specialists">Сотрудники</a></li>
                                    <li><a href="/admin/tasks">Список задач</a></li>
                                @endif
                                @if (Auth::user()->role == 'specialist')
                                    <li><a href="/admin/tasks">Список задач</a></li>
                                @endif
                            @else
                                <li class="welcome">Добро пожаловать</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-3">
                        @if (Auth::user())
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="navbar-link btn">
                                Выйти ({{Auth::user()->name}})
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
@yield('content')

<script src="/public/js/jquery.min.js"></script>
<script src="/public/js/bootstrap.min.js"></script>
</body>
</html>
