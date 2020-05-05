@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
        @foreach($courses as $course)
        @if($course->is_published)
        <div class="col mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $course->subject }}</h6>
                    <p class="card-text"><small class="text-muted">Автор: {{ $course->author->name }} {{ $course->author->surname }}</small></p>
                    <a class="stretched-link" href="{{ route('courseInfo', $course->id) }}"></a>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    {{ $courses->links() }}
</div>
@endsection