@extends('layouts.app')

@section('title')Редагування курсу@endsection

@section('content')
<div class="container my-5">
    <h2>{{ $course->name }}</h2>
    <hr class="mb-4">
    @error('test')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
         </button>
    </div>
    @enderror

    <form method="POST" action="{{ route('saveUpdatedCourse', $course->id) }}">
        @csrf
        <div class="form-group">
            <label for="name">Назва курсу:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $course->name }}">
            @error('name')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Опис курсу:</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $course->description }}</textarea>
        </div>
        <div class="form-group" id="tests-form">
        @error('test.*')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @enderror
            <button type="button" class="btn btn-outline-secondary" onclick="addTest()">Додати тест</button>
            @foreach($course->tests as $test)
            <div class="container my-3 input-group" id="{{ $test->id }}">
                <input type="text" class="form-control" id="test-{{ $test->id }}" name="test[{{ $test->id }}]" value="{{ $test->name }}">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" data-test-id="{{$test->id}}" onclick="removeTest(this)">Видалити тест</button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Зберегти зміни</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/testInputs.js') }}"></script>
@endpush