@extends('layouts.app')

@section('title')Редагування тесту {{ $test->name }}@endsection

@section('content')
<div class="container my-5">
    <h2>{{ $test->course->name }}<br>
        <small class="text-muted">{{ $test->name }}</small>
    </h2>
    <hr class="mb-4">
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div id="warning"></div>
    <button type="button" class="btn btn-outline-dark mb-3" id="btn" data-route="{{ route('saveQuestion', $test->id) }}" onclick="add(this)">Додати запитання</button>
    <div class="row">
        <div class="col-md-3">
            <div class="nav flex-column nav-pills border rounded p-1 mb-3 bg-white" id="v-pills-tab" role="tablist">
                @foreach($test->questions as $question)
                <a class="nav-link" id="question-tab-{{ $question->id }}" data-toggle="pill" href="#question-{{ $question->id }}" role="tab">Питання №{{ $loop->iteration }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                @foreach($test->questions as $question)
                <div class="tab-pane fade" id="question-{{ $question->id }}" role="tabpanel">
                    <form method="POST" action="{{ route('updateQuestion', [$test->id, $question->id]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="text-{{ $question->id }}">Текст запитання:</label>
                            <textarea class="form-control" name="text" id="text-{{ $question->id }}" rows="3">{{ $question->text }}</textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6 col-md-7 col-lg-8">
                                <label for="type-{{ $question->id }}">Тип запитання:</label>
                                <select class="form-control" name="type" id="type-{{ $question->id }}" data-id="{{ $question->id }}" onchange="typeSelect(this)">
                                    @foreach($questionTypes as $key => $value)
                                    <option value="{{ $key }}" @if($question->type == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-5 col-lg-4">
                                <label for="answersCount-{{ $question->id }}">Кількість відповідей:</label>
                                <select class="form-control" id="answersCount-{{ $question->id }}" data-id="{{ $question->id }}" onchange="answersSelect(this)" @if($question->type == 'writeAnswer') disabled @endif>
                                    @for($i = 2; $i < 7; $i++)
                                    <option value="{{ $i }}" @if($question->answers->count() == $i) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div id="answers-block-{{ $question->id }}">
                            <div class="form-group">
                            @if($question->type == 'writeAnswer')
                                <label for="answer-1">Текст відповіді:</label> 
                                <input type="text" class="form-control" id="answer-1" name="answers[{{ $question->answers[0]->id }}]" value="{{ $question->answers[0]->text }}"> 
                            @else
                                @foreach($question->answers as $answer)
                                    <label for="answer-{{ $answer->id }}">Текст відповіді №{{ $loop->iteration }}:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="answer-{{ $answer->id }}" name="answers[{{ $answer->id }}]" value="{{ $answer->text }}">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                @if($question->type == 'oneAnswer')
                                                    <input type="radio" name="right-answers[]" value="{{ $answer->id }}" @if($answer->is_correct) checked @endif>
                                                @elseif($question->type == 'fewAnswers')
                                                    <input type="checkbox" name="right-answers[]" value="{{ $answer->id }}" @if($answer->is_correct) checked @endif>  
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Зберегти</button>
                        <a href="{{ route('deleteQuestion', [$test->id, $question->id]) }}" class="btn btn-danger">Видалити запитання</a>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/questionInputs.js') }}"></script>
@endpush