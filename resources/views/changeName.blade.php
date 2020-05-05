@extends('layouts.app')

@section('title')Профіль@endsection

@section('content')
<div class="container my-5">
    <div class="container">
        <form action="#" method="post">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Ім'я:</label>
                <div class="col-sm-10">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}">
                    @error('name')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="surname" class="col-sm-2 col-form-label">Прізвище:</label>
                <div class="col-sm-10">
                    <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ $user->surname }}">
                    @error('surname')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Підтвердити</button>
        </form>
    </div>
</div>
@endsection