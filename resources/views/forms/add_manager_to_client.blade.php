@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Добавить менеджера для заказчика</h1>
                <p><a href="/admin">Назад</a></p>
                <form method="post" action="/admin/add-manager-to-client">

                    <label for="">Заказчики</label>
                    <select class="form-control" name="company">
                        @foreach ($clients as $client)
                            <option value="{{$client->id}}">{{$client->name}}</option>
                        @endforeach
                    </select>

                    <label for="">Менеджеры</label>
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