@extends('layouts.app')

@section('title')Мої курси@endsection

@section('content')
<div class="container my-5">
    @error('error')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
         </button>
    </div>
    @endif
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#subscribes" role="tab">Підписки на курси</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#createdCourses" role="tab">Створені курси</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="subscribes" role="tabpanel">
            @foreach($subscriptions as $subscription)
            <div class="container my-1 py-3 border rounded">
                <h4>{{ $subscription->name }}</h4><hr>
                <details>
                    <summary>Опис курсу</summary>
                    <p>{{ $subscription->description }}</p>
                </details>
                <p><small class="text-muted">Автор: {{ $subscription->author->name }} {{ $subscription->author->surname }}</small></p>
                <p>Кількість тестів: {{ $subscription->tests->count() }}</p>
                <a href="{{ route('courseInfo', $subscription->id) }}" class="btn btn-secondary mb-1">Перейти</a>
                <a href="{{ route('unsubscribe', $subscription->id) }}" class="btn btn-danger mb-1">Відписатися</a>
            </div>
            @endforeach
        </div>
        <div class="tab-pane fade" id="createdCourses" role="tabpanel">
            @foreach($createdCourses as $course)
            <div class="container my-1 py-3 border rounded">
                <h4>{{ $course->name }}</h4><hr>
                <details>
                    <summary>Опис курсу</summary>
                    <p>{{ $course->description }}</p>
                </details>
                <details class="mb-2">
                    <summary class="mb-2">Кількість тестів: {{ $course->tests->count() }}</summary>
                    @foreach($course->tests as $test)
                    <p><a href="{{ route('editTest', $test->id) }}">{{ $test->name }}</a></p>
                    @endforeach
                </details>
                @if($course->is_published)
                <a href="{{ route('unpublishCourse', $course->id) }}" class="btn btn-primary mb-1">Зняти з публікації</a>
                @else
                <a href="{{ route('publishCourse', $course->id) }}" class="btn btn-primary mb-1">Публікувати</a>
                @endif
                <a href="{{ route('courseInfo', $course->id) }}" class="btn btn-info mb-1">Перейти</a>
                <a href="{{ route('updateCourse', $course->id) }}" class="btn btn-secondary mb-1">Редагувати</a>
                <a href="{{ route('deleteCourse', $course->id) }}" class="btn btn-danger mb-1">Видалити</a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade show active" id="subscribes" role="tabpanel" aria-labelledby="subscribes-tab"></div>
</div>

@endsection