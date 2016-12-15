@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Добавление / редактирование компании</h1>
                <p><a href="/admin">Назад</a></p>
                <form method="post" action="/admin/{{$link}}/{{Auth::user()->id}}">
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputName" placeholder="@if(!empty($company->name)) {{$company->name}} @endif{{--$user->name--}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputWebsite">Website</label>
                        <input type="text" class="form-control" name="website" id="exampleInputWebsite" placeholder="@if(!empty($company->website)) {{$company->website}} @endif {{--$user->email--}}">
                    </div>

                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
        </div>
    </div>
@endsection