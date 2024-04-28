@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $post->title }}</div>

                    <div class="card-body">
                        <p class="card-text">{!! $post->content !!}</p>

                        <p>
                            @foreach ($post->attachment as $attancment)
                                <a href="{{ $attancment->url }}">
                                    <img src="{{ $attancment->url }}" alt="{{ $attancment->name }}" class="img-fluid">
                                </a>
                            @endforeach
                        </p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>{{ __('Author') }}</strong>
                                <span class="ms-2 text-muted">{{ $post->user->name }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>{{ __('Created') }}</strong>
                                <span class="ms-2 text-muted">{{ $post->created_at->diffForHumans() }}</span>
                            </li>
                            @if($post->created_at != $post->updated_at)
                            <li class="list-group-item">
                                <strong>{{ __('Updated') }}</strong>
                                <span class="ms-2 text-muted">{{ $post->updated_at->diffForHumans() }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5>{{ __('Comments') }}</h5>
                        @auth
                        <div class="mb-3">
                            <form action="{{ route('post.comment.create', $post->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control" name="text" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Comment') }}
                                </button>
                            </form>
                        </div>
                        @endauth
                        @if($post->comments->count() == 0)
                            <p class="card-text">{{ __('No comments yet') }}</p>
                        @else
                            @foreach ($post->comments as $comment)
                                <div class="card">
                                    <div class="card-header">{{ $comment->user->name }}</div>
                                    <div class="card-body">
                                        <p class="card-text">{{ $comment->text }}</p>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>


                    <div class="card-footer">
                        <a href="{{ route('welcome') }}">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection