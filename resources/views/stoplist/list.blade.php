@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Телефонные номера</div>

                    <div class="card-body">
                        <a href="/stoplist/store" class="btn btn-primary">Создать</a>
                        <div class="row mt-5">
                            <div class="col-5">
                                    Номер телефона
                            </div>
                        </div>
                       @if($phones->isNotEmpty())
                            @foreach($phones as $phone)
                                <div class="row mt-2">
                                    <div class="col-4">
                                        {{ $phone->number  }}
                                    </div>
                                    <div class="col-2">
                                        <a href="/stoplist/{{ $phone->id }}/details" class="btn btn-sm btn-primary">Изменить</a>

                                    </div>
                                    <div class="col-2">
                                        <a href="/stoplist/{{ $phone->id }}/remove" class="btn btn-sm btn-danger">Удалить</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                           <div class="alert alert-info mt-2" >
                                <span>
                                    Список пуст
                                </span>
                           </div>
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
