<div class="col-xl-8 py-5 px-md-5">
    <div class="row pt-md-4">
        @forelse($articles as $article)
        <div class="col-md-12">
            <div class="blog-entry ftco-animate d-md-flex">
                <a href="{{ route('article', [app()->getLocale(), $article->category->path, $article->slug]) }}" class="img img-2"
                   style="background-image: url({{ $article->page_image ?? config('settings.image_cap')}});">
                </a>
                <div class="text text-2 pl-md-4">
                    <h3 class="mb-2">
                        <a href="{{ route('article', [app()->getLocale(), $article->category->path, $article->slug]) }}">
                            {{ $article->title }}
                        </a>
                    </h3>
                    <div class="meta-wrap">
                        <p class="meta">
                            <span>
                                <i class="icon-calendar mr-2"></i>
                                {{ $article->published_at->format('m/d/Y H:i') }}
                            </span>
                            <span>
                                <a href="{{ url(app()->getLocale(), $article->category->path)}}">
                                    <i class="icon-folder-o mr-2"></i>
                                    {{$article->category->name}}
                                </a>
                            </span>
                            @if ($article->comments->count() > 0)
                                <br>
                                <span>
                                    <i class="icon-comment2 mr-2"></i>
                                    {{ trans_choice('blog.comment', $article->comments->count() )}}
                                </span>
                            @endif
                        </p>
                    </div>
                    <p class="mb-4">{{ $article->subtitle }}</p>
                    <p>
                        <a href="{{ route('article', [app()->getLocale(), $article->category->path, $article->slug]) }}" class="btn-custom">
                            {{__('blog.readMore')}} <span class="ion-ios-arrow-forward"></span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        @empty
            <h3 class="text-center">{{__('blog.articlesNotFound')}}</h3>
        @endforelse
    </div>
    {{ $articles->links('pagination.default') }}
</div>
