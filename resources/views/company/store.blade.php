@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создать новую компанию</div>

                    <div class="card-body">
                        <form action="{{route('company.store')}}" method="post">
                            @csrf
                            <input type="text" class="form-control" placeholder="название компании" name="name">
                            <input type="submit" class="btn btn-primary btn-small mt-2">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
