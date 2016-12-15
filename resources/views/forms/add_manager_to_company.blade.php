@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Добавить менеджера в компанию</h1>
                <p><a href="/admin">Назад</a></p>
                <form method="post" action="/admin/add-manager-company">

                    <select class="form-control" name="company">
                        @foreach ($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                    </select>

                    <select class="form-control" name="manager">
                        @foreach ($managers as $manager)
                            <option value="{{$manager->id}}">{{$manager->name}}</option>
                        @endforeach
                    </select>

                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-default">Добавить</button>
                </form>

            </div>
        </div>
    </div>
@endsection