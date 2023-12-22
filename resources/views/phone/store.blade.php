@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Добавить номер телефона</div>

                    <div class="card-body">
                        <form action="{{ route('phones.store')  }}" method="post">
                            @csrf
                            <div class="">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="number" name="phone" >
                                    <label for="number">Номер телефона</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="token" name="token">
                                    <label for="token">Токен</label>
                                </div>
                                <input type="submit" class="btn btn-sm btn-primary mt-2" value="сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
