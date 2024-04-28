@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Posts') }}</div>
                    <div class="card-body">
                        <ul class="list-group">
                        @foreach ($posts as $post)
                            <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <a href="{{ route('post.show', $post->id) }}">
                                        <h5 class="mb-1">{{ $post->title }}</h5>
                                    </a>
                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{!! Str::limit($post->content, 100, '...') !!}</p>
                                <small class="text-muted">{{ $post->user->name }}</small>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection
