@extends('layouts.app')

@section('title')Тест {{ $test->name }}@endsection

@section('content')
<div class="container my-5">
    <h2>{{ $test->course->name }}<br>
        <small class="text-muted">{{ $test->name }}</small>
    </h2>
    <hr class="mb-4">
    <form action="{{ route('testingEvaluation', $test->id) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <div class="nav d-flex flex-wrap align-content-start nav-pills border rounded p-1 mb-3 bg-white" id="pills-tab" role="tablist">
                    @foreach($test->questions as $question)
                    <a class=@if($loop->first)"nav-link active"@else"nav-link"@endif id="question-tab-{{ $question->id }}" data-toggle="pill" href="#question-{{ $question->id }}" role="tab">{{ $loop->iteration }}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="pills-tabContent">
                    @foreach($test->questions as $question)
                    <div class=@if($loop->first)"tab-pane fade active show"@else"tab-pane fade"@endif id="question-{{ $question->id }}" role="tabpanel">
                        <div class="border rounded bg-white p-2">
                            <p>{{ $question->text }}</p>
                        </div>
                        <div class="form-group my-3 bg-white p-2 rounded border">
                            @if($question->type === 'writeAnswer')
                            <label for="answer-{{ $question->answers[0]->id }}">Ваша відповідь:</label>
                            <input type="text" class="form-control bg-light" name="answers[{{ $question->id }}]" placeholder="Ведіть відповідь">
                            @else
                            @foreach($question->answers as $answer)
                            <div class="form-check mb-3">
                                @if($question->type === 'oneAnswer')
                                <input class="form-check-input" id="answer-{{ $question->id }}-{{ $answer->id }}" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}">
                                @elseif($question->type === 'fewAnswers')
                                <input class="form-check-input" id="answer-{{ $question->id }}-{{ $answer->id }}" type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $answer->id }}">
                                @endif
                                <label class="form-check-label" for="answer-{{ $question->id }}-{{ $answer->id }}">{{ $answer->text }}</label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="previous" class="btn btn-primary">Назад</button>
                    <button type="submit" id="submit" class="btn btn-primary">Завершити</button>
                    <button type="button" id="next" class="btn btn-primary">Далі</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/testing.js') }}"></script>
@endpush