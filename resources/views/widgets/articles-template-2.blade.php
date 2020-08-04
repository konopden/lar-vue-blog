<div class="col-xl-8 px-md-5 py-5">
    <div class="row pt-md-4">
        @forelse($articles as $article)
            <div class="col-md-12">
                <div class="blog-entry-2 ftco-animate">
                    <a href="{{ url($article->slug) }}" class="img"
                       style="background-image: url({{ $article->page_image ?? config('settings.image_cap')}});">
                    </a>
                    <div class="text pt-4">
                        <h3 class="mb-4">
                            <a href="{{ route('article', [app()->getLocale(), $article->category->path, $article->slug]) }}">
                                {{ $article->title }}
                            </a>
                        </h3>
                        <p class="mb-4">
                            {{ $article->published_at->format('m/d/Y H:i') }}
                        </p>
                        <div class="author mb-4 d-flex align-items-center">
                            <a href="#" class="img" style="background-image: url({{ $article->user->avatar }});"></a>
                            <div class="ml-3 info">
                                <span>{{__('blog.writtenBy')}}</span>
                                <h3>
                                    <span>{{ $article->user->name }}</span>
                                </h3>
                            </div>
                        </div>
                        <div class="meta-wrap d-md-flex align-items-center">
                            <div class="half order-md-last text-md-right">
                                <p class="meta">
                                    <span><i class="icon-eye"></i>{{ $article->view_count }}</span>
                                    <span><i class="icon-comment"></i>{{ $article->comments->count() }}</span>
                                </p>
                            </div>
                            <div class="half">
                                <p>
                                    <a href="{{ route('article', [app()->getLocale(), $article->category->path, $article->slug]) }}"
                                       class="btn btn-primary p-3 px-xl-4 py-xl-3">
                                        {{__('blog.continueReading')}}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h3 class="text-center">{{__('blog.articlesNotFound')}}</h3>
        @endforelse
    </div><!-- END-->
    {{ $articles->links('pagination.default') }}
</div>
