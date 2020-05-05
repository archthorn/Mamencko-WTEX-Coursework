@extends('layouts.app')

@section('title')Створити курс@endsection

@section('content')
<div class="container my-5">
    <form method="POST" action="{{ route('saveCourse') }}">
        @csrf
        <div class="form-group">
            <label for="name">Назва курсу:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Введіть назву курсу">
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="subject">Предмет курсу:</label>
            <select class="form-control" id="subject" name="subject">
            @foreach($subjects as $subj)
            <option>{{ $subj }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Опис курсу:</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Введіть опис курсу"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Створити курс</button>
    </form>
</div>
@endsection