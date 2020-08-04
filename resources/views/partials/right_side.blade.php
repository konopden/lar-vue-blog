<div class="col-xl-4 sidebar ftco-animate bg-light pt-5">
    <div class="sidebar-box pt-md-4">
        <search></search>
    </div>
    <div class="sidebar-box ftco-animate">
        <h3 class="sidebar-heading">{{__('blog.categories')}}</h3>
        <ul class="categories">
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('category', [app()->getLocale(), $category->path]) }}">
                        {{$category->name}} <span>({{$category->articles->count()}})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="sidebar-box ftco-animate">
        <h3 class="sidebar-heading">{{__('blog.popularArticles')}}</h3>
        @foreach ($topArticles as $article)
            <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4"
                   style="background-image: url({{ $article->page_image ?? config('settings.image_cap')}});"></a>
                <div class="text">
                    <h3 class="heading">
                        <a href="{{ route('article', [app()->getLocale(), $article->category->path, $article->slug]) }}">
                            {{ $article->title }}
                        </a>
                    </h3>
                    <div class="meta">
                        <div>
                            <span class="icon-calendar"></span>
                            {{ $article->published_at->format('M d, Y') }}
                        </div>
                        <div><span class="icon-person"></span>{{ $article->user->name }}</div>
                        <div><span class="icon-chat"></span> {{$article->comments->count()}}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="sidebar-box ftco-animate">
        <h3 class="sidebar-heading">{{__('blog.tagCloud')}}</h3>
        <ul class="tagcloud">
            @foreach ($tags as $tag)
                @if($tag->articles->count() > 0)
                    <a href="{{ url('/' . app()->getLocale() . '/tag', ['tag' => $tag->tag]) }}" class="tag-cloud-link">
                        {{$tag->tag}}
                    </a>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="sidebar-box subs-wrap img py-4" style="background-image: url(/images/logo_background.png);">
        <div class="overlay"></div>
        <h3 class="mb-4 sidebar-heading">{{__('blog.newsletter')}}</h3>
        <p class="mb-4">{{__('blog.newsletterDesc')}}</p>
        <subscribe-vertical></subscribe-vertical>
    </div>

    <div class="sidebar-box ftco-animate">
        <h3 class="sidebar-heading">{{__('blog.archives')}}</h3>
        <ul class="categories">
            @foreach($archives as $archive)
                <li>
                    <a href="{{ '/' . app()->getLocale() }}/?month={{$archive->month}}&year={{$archive->year}}">
                        {{$archive->month}} {{$archive->year}} <span>({{$archive->published}})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="sidebar-box ftco-animate">
        <h3 class="sidebar-heading">{{__('blog.info')}}</h3>
        <p>Some text...</p>
    </div>
</div>
