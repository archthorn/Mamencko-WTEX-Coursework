@extends('layouts.app')

@section('title')Тест {{ $test->name }}@endsection

@section('content')
<div class="container my-5">
    <h2>{{ $test->course->name }}<br>
        <small class="text-muted">{{ $test->name }}</small>
    </h2>
    <hr class="mb-4">
    <p>Оцінка за останнє тестування: {{ $result * 100 }}/100</p>
    <a href="{{ route('courseInfo', $test->course->id) }}" class="btn btn-outline-info">Повернутися на сторінку курсу</a>
    <a href="{{ route('testing', $test->id) }}" class="btn btn-outline-dark">Пройти тестування ще раз</a>
    <div class="container my-3">
        @foreach($test->questions as $question)
        <div class="border rounded bg-white p-2 mb-3">
            <p class="m-3">{{ $question->text }}</p>
            @if($question->type === 'writeAnswer')
            <div class="alert {{ $userAnswers->where('question_id', $question->id)->pluck('is_passed')->first() ? 'alert-success' : 'alert-danger' }}">
                <p>Ваша відповідь: {{ $userAnswers->where('question_id', $question->id)->pluck('written_answer')->first() ?? 'Ви не вказали відповідь' }}</p>
            </div>
            @if(!$userAnswers->where('question_id', $question->id)->pluck('is_passed')->first())
            <div class="alert alert-success">
                <p>Правильна відповідь: {{ $question->answers->where('is_correct', true)->pluck('text')->first() }}</p>
            </div>
            @endif
            @elseif($question->type === 'oneAnswer')
            <div class="alert {{ $userAnswers->where('question_id', $question->id)->pluck('is_passed')->first() ? 'alert-success' : 'alert-danger' }}">
                <p>Ваша відповідь: {{ $userAnswers->where('question_id', $question->id)->first()->answer->text ?? 'Ви не вказали відповідь' }}</p>
            </div>
            @if(!$userAnswers->where('question_id', $question->id)->pluck('is_passed')->first())
            <div class="alert alert-success">
                <p>Правильна відповідь: {{ $question->answers->where('is_correct', true)->pluck('text')->first() }}</p>
            </div>
            @endif
            @elseif($question->type === 'fewAnswers')
                @foreach($userAnswers->where('question_id', $question->id) as $val)
                <div class="alert {{ $val->is_passed ? 'alert-success' : 'alert-danger' }}">
                    <p>Ваша відповідь: {{ $val->answer->text }}</p>
                </div>
                @endforeach
                @if($userAnswers->where('question_id', $question->id)->pluck('is_passed')->contains(false))
                <div class="alert alert-success">
                    <p>Правильна відповідь: 
                    @foreach($question->answers->where('is_correct', true) as $val)
                    {{ $val->text.'; ' }}
                    @endforeach
                    </p>
                </div>
                @endif
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
@endpush