@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Список всех задач</h1>

                @if (!$tasks->count())
                    There is no post till now. Login and write a new post now!!!
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Имя</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{$task->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
@endsection