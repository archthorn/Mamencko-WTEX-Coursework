@extends('layouts.app')

@section('title'){{ $course->name }}@endsection

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-5">{{ $course->name }}</h1>
        @if($course->created_by === Auth::user()->id)
            @if($course->is_published)
            <a href="{{ route('unpublishCourse', $course->id) }}" class="btn btn-primary mb-1">Зняти з публікації</a>
            @else
            <a href="{{ route('publishCourse', $course->id) }}" class="btn btn-primary mb-1">Публікувати</a>
            @endif
        <a href="{{ route('updateCourse', $course->id) }}" class="btn btn-secondary mb-1">Редагувати</a>
        <a href="{{ route('deleteCourse', $course->id) }}" class="btn btn-danger mb-1">Видалити</a>
        @elseif($isSubscribed)
        <a href="#" class="btn btn-secondary">Перейти до курсу</a>
        <a href="{{ route('unsubscribe', $course->id) }}" class="btn btn-danger mb-1">Відписатися</a>
        @else
        <a href="{{ route('subscribe', $course->id) }}" class="btn btn-success mb-1">Підписатися на курс</a>
        @endif
        <p><small class="text-muted">Автор: {{ $course->author->name }} {{ $course->author->surname }}</small></p>
    </div>
</div>
<div class="container my-5">
    @error('error')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
         </button>
    </div>
    @enderror
    <h2>Про цей курс</h2>
    <p>Предмет: {{ $course->subject }}</p>
    <p class="mx-3">{{ $course->description }}</p>
</div>
<div class="container">
    <h4>Тести:</h4>
    <div class="container">
        @foreach($course->tests as $test)
        <details>
            <summary>{{ $test->name }}</summary>
            <div class="container mb-3">
                @if($course->is_published || $course->created_by === Auth::user()->id)
                <p>Запитань в тесті: {{ $test->questions->count() }}</p>
                <a href="{{ route('testingResults', $test->id) }}" class="btn btn-outline-success mb-1">Переглянути результати</a>
                <a href="{{ route('testing', $test->id) }}" class="btn btn-outline-dark mb-1">Почати тестування</a>
                @else
                <p>Курс знаходиться на редагуванні.</p>
                @endif
            </div>
        </details>
        @endforeach
    </div>
</div>
@endsection