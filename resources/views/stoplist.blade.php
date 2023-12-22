@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Стоп лист</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Номер</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($lists->isNotEmpty())
                                @foreach($lists as $key => $list)
                                    <tr>
                                        <th scope="row">{{$key + 1}}</th>
                                        <td>{{$list->number}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <div class="text-center">
                                    Список команий пусть
                                </div>

                            @endif

                            </tbody>
                        </table>

                        <div class="text-start">
                            <a class="btn btn-primary btn-sm" href="/company/store">Создать команию</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
