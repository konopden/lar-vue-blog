@extends('app')
@section('content')
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row d-flex">
                <div class="col-lg-8 px-md-5 py-5">
                    <div class="row pt-md-4">
                        <h1 class="mb-3">{{ $article->title }}</h1>
                        <div class="container">
                            {{ $article->content }}
                            <div class="tag-widget post-tag-container mb-5 mt-5">
                                <div class="tagcloud">
                                    @foreach($article->tags as $tag)
                                        <a href="{{ url('/' . app()->getLocale() . '/tag', ['tag' => $tag->tag]) }}"
                                           class="tag-cloud-link">
                                            {{ $tag->tag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="about-author d-flex p-4 bg-light">
                                <div class="bio mr-2">
                                    <img src="{{ ($avatar = $article->user->avatar) ? $avatar : config('settings.image_cap') }}"
                                         alt="Image placeholder" class="img-fluid mb-4">
                                </div>
                                <div class="desc container">
                                    <h3>{{ $article->user->name }}</h3>
                                    <div>{{ $article->user->info }}</div>
                                </div>
                            </div>
                        </div>
                        <comment
                                user-name="Test"
                                user-avatar="https://picsum.photos/id/132/150/150"
                                article-id="{{ $article->id }}"></comment>
                    </div>
                </div>
                @include('partials.right_side')
            </div>
        </div>
    </section>
@endsection
