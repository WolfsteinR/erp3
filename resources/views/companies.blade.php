@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Список компаний</h1>
                <p><a href="/admin">Назад</a></p>
                @if (!$companies->count())
                    There is no post till now. Login and write a new post now!!!
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Название компании</th>
                            <th>Сайт</th>
                        </tr>
                        </thead>
                        <tbody>
                    @foreach ($companies as $company)
                            <tr>
                                <td>{{$company->name}}</td>
                                <td>{{$company->website}}</td>
                            </tr>
                    @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection