@extends('app')

@section('content')
    <div class="row d-flex">
        <section class="user col-lg-8 px-md-5 py-5">
            <div class="row info">
                <div class="col-sm-3 text-center">
                    <img class="avatar rounded-circle" src="{{ $user->avatar }}">
                </div>
                <div class="col-sm-5 content">
                    <div class="h3">
                        {{ $user->name }}
                    </div>
                    <div class="description">
                        {{ $user->info }}<br>
                        <span class="counter">{{count($comments)}}</span> {{__('blog.comments')}}
                    </div>
                    @if(Auth::check())
                        <div class="actions">
                            @can('update', $user)
                                <a href="{{ url('/'.app()->getLocale().'/user/profile') }}" class="btn btn-primary btn-sm">
                                    {{__('blog.editProfile')}}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="comments">
                @if (count($comments) > 0)
                    <h3 class="font-weight-bold">{{__('blog.lastComments')}}</h3>
                    <ul class="comment-list">
                        @foreach($comments as $comment)
                            <li class="comment">
                                <div class="meta">{{$comment->created_at}}</div>
                                <p>{{$comment->content}}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <h3 class="font-weight-bold">{{__('blog.noComments')}}</h3>
                @endif
            </div>
        </section>
        @include('partials.right_side')
    </div>
@endsection
