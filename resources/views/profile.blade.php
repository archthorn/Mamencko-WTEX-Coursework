@extends('layouts.app')

@section('title')Профіль@endsection

@section('content')
<div class="container my-5">
    <h2>Профіль користувача</h2>
    <hr class="mb-4">
    <div class="container">
        <h4 class="">Ім'я: {{ $user->name }}</h4>
        <h4 class="">Прізвище: {{ $user->surname }}</h4>
        <a class="btn btn-primary mb-1" href="{{ route('changeName') }}">Змінити ім'я</a>
        <a class="btn btn-warning mb-1" href="{{ route('password.request') }}">Скинути пароль</a>
        <p class="">Створено курсів: {{ $user->createdCourses->count() }}</p>
        <p class="">Підписок на курси: {{ $user->courses->count() }}</p>
        <a class="btn btn-info mb-1" href="{{ route('userCourses') }}">Перейти до курсів</a>
        <a class="btn btn-primary mb-1" href="{{ route('createCourse') }}">Створити новий курс</a>
    </div>
</div>
@endsection
