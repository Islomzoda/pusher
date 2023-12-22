@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header fs-4">{{$company->name}}</div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-3 border border-dark">
                                <div class="mt-2">
                                    Состояние: {{\App\Helpers\Status::company($company->status) . ' (отправлено ' . $company->completed . ' из ' . $company->clients_count . ')' }}
                                    <br>
                                    @if($company->status == 'waiting_start')
                                        <a href="/company/{{$company->id}}/start" class="btn btn-primary btn-small">Старт</a>
                                        {{--                                            @elseif($company->status == 'stopped')--}}
                                        {{--                                                <a href="/company/{{$company->id}}/resume" class="btn btn-primary btn-small">Возобновить</a>--}}
                                    @elseif($company->status == 'dispatching')
                                        <a href="/company/{{$company->id}}/stop" class="btn btn-primary btn-small">Остановить</a>
                                    @else
                                        <div>Нет Действий</div>
                                    @endif

                                    <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                                            <div class="text-left mt-2">
                                            <input type="file" name="file" class="form-control" id="customFile">
                                            </div>
                                        </div>
                                        <input type="number" name="company_id" value="{{$company->id}}" hidden>
                                        <button class="btn btn-primary btn-sm">Импорт</button>
                                    </form>
                                    <a href="{{route('file-export', ['company_id' => $company->id])}}" class="btn btn-sm btn-warning mt-2">Экспорт</a>
                                </div>
                            </div>
                            <div class="col-9 border border-dark ">
                                <form action="{{ route('company.save') }}" method="post" class="row">
                                    <div class="col-9">
                                        @csrf
                                        <input type="number" name="company_id"  value="{{$company->id}}"  hidden>
                                        <div class="form-group mt-2 row">
                                            <div class="col-5">
                                                <label for="daysOfWeek" class="me-2">Дни недели: </label>
                                            </div>
                                            <div class="col-7 d-flex">
                                                @foreach(['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс'] as $day)
                                                    <div class="form-check">
                                                        <input type="checkbox" class=" form-check-input" id="{{ $day }}" name="daysOfWeek[]" value="{{ $day }}" {{ (is_null($company->days_of_week) || in_array($day, json_decode($company->days_of_week, true))) ? 'checked' : '' }}>
                                                        <label class="form-check-label pe-1" for="{{ $day }}">{{ $day }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                Время рассылки:
                                            </div>
                                            <div class="col-1">
                                                с
                                            </div>
                                            <div class="col-3">
                                                <input type="time" name="start_time" placeholder="11" value="{{ $company->start_time }}" class="form-control" required>
                                            </div>
                                            <div class="col-1">
                                                по
                                            </div>
                                            <div class="col-3">
                                                <input type="time" name="end_time" value="{{ $company->end_time }}" placeholder="17" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                    <span class="col-4">
                                        Интервал между сообщениям (секунд):
                                    </span>
                                            <div class="col-1">
                                                с
                                            </div>
                                            <div class="col-3">
                                                <input type="text" name="interval_min" value="{{ $company->interval_min }}" placeholder="30" class="form-control" required>
                                            </div>
                                            <div class="col-1">
                                                по
                                            </div>
                                            <div class="col-3">
                                                <input type="text" name="interval_max" value="{{ $company->interval_max }}" placeholder="150" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-5">
                                                <label for="start_day">
                                                    Начать с
                                                </label>
                                            </div>
                                            <div class="col-7">
                                                <input type="date" name="start_day" value="{{ $company->start_day }}" id="start_day" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-5">
                                                <label for="from_number">
                                                    Отправить с номера
                                                </label>

                                            </div>
                                            <div class="col-7">
                                                <select class="form-select"  name="from_number" aria-label="Default select example" required>
                                                    @foreach($phones as $phone)
                                                        <option value="{{$phone->phone}}" {{ $company->from_number == $phone->phone ? 'selected' : ''}}>{{$phone->phone}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-5">
                                                <label for="from_number">
                                                    Выберите сервис
                                                </label>
                                            </div>
                                            <div class="col-7">
                                                <select class="form-select"  name="service_name" aria-label="Default select example" required>
                                                    <option value="whatsapp" selected>WhatsApp</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                    <span>
                                        Расчетное время завершение рассылки: {{$days}} дней
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-3 border border-dark text-end">
                                        <input type="submit"  class="btn btn-primary btn-sm mt-2"  value="сохранить">
                                        <br>
                                        @if($company->start_day)
                                            <a href="/company/{{$company->id}}/generate" class="btn btn-sm btn-primary mt-2">Запланировать</a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md">
                <table class="table table-bordered">
                    <thead>
                    <tr class="table-secondary">
                        <th scope="col">#</th>
                        <th scope="col">Куда</th>
                        <th scope="col">Сообщение   <button onclick="show()" >Укоротить/Раскрыть текст</button></th>
                        <th scope="col">URL - изображение</th>
                        <th scope="col">отправить в</th>
                        <th scope="col">статус </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($clients->isNotEmpty())
                        @foreach($clients as $key => $client)
                            <tr>
                                <th scope="row">{{$key}}</th>
                                <td>{{$client->number}}</td>
                                <td>
                                    <div class="textItem">
                                        <div class="originalText" >
                                            {{ $client->sms }}
                                        </div>
                                        <div class="truncatedText"></div>
                                        <button onclick="toggleText(this)" hidden>Укоротить/Раскрыть текст</button>
                                    </div>
                                    </td>
                                <td>{{ $client->img_url ? substr($client->img_url, -17) : "нет" }}</td>
                                <td>{{ $client->send_at }}</td>
                                <td>{{ \App\Helpers\Status::client($client->status) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <div class="alert alert-info mt-2">
                            <span>
                                Список пуст пожалуйста импортируйте список клиентов
                            </span>
                        </div>
                    @endif
                    <tr>
                        <td colspan="6">{{ $clients->links() }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleText(button) {
            var textContainer = button.parentElement;
            var originalText = textContainer.querySelector(".originalText");
            var truncatedText = textContainer.querySelector(".truncatedText");
            if (originalText.style.display === 'none') {
                originalText.style.display = 'block';
                truncatedText.style.display = 'none';
            } else {
                var textContent = originalText.textContent.slice(0, 100);
                truncatedText.textContent = textContent;
                originalText.style.display = 'none';
                truncatedText.style.display = 'block';
            }
        }

       function show() {
           var textItems = document.querySelectorAll('.textItem');
           textItems.forEach(function(item) {
               toggleText(item.querySelector('button'));
           });
       }
        show()
    </script>
@endsection
