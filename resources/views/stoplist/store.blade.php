@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Добавить номер телефона</div>

                    <div class="card-body">
                        <form action="{{ route('stoplist.store')  }}" method="post">
                            @csrf
                            <div class="">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="number" name="number" >
                                    <label for="number">Номер телефона</label>
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
