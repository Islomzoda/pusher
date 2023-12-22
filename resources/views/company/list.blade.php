@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Компании</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Название</th>
                                <th scope="col">Состояние</th>
                                <th scope="col">Примечание</th>
                                <th scope="col">Действие</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($companies->isNotEmpty())
                                @foreach($companies as $key => $company)
                                    <tr>
                                        <th scope="row">{{$key + 1}}</th>
                                        <td><a href="/company/{{$company->id}}/details">{{$company->name}}</a></td>
                                        <td> {{ $company->status  }}</td>
                                        <td> {{ 'отправлено ' . $company->completed . ' из ' . $company->clients_count }}</td>
                                        <td>
                                            @if($company->status == 'waiting_start')
                                                 <a href="/company/{{$company->id}}/start" class="btn btn-primary btn-small">Старт</a>
{{--                                            @elseif($company->status == 'stopped')--}}
{{--                                                <a href="/company/{{$company->id}}/resume" class="btn btn-primary btn-small">Возобновить</a>--}}
                                            @elseif($company->status == 'dispatching')
                                                <a href="/company/{{$company->id}}/stop" class="btn btn-primary btn-small">Остановить</a>
                                            @else
                                                <div>Нет Действий</div>
                                            @endif
                                        </td>
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
