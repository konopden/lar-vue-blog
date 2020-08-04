<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
<aside id="colorlib-aside" role="complementary" class="js-fullheight">
    <nav id="colorlib-main-menu" role="navigation">
        <ul class="lang-menu">
            @foreach (config('app.available_locales') as $locale)
                @if (app()->getLocale() == $locale)
                    <li class="active-lang">
                        <a>
                            {{ strtoupper($locale) }}
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ url($locale . preg_replace('#^'.app()->getLocale().'#is', '', request()->path())) }}">
                            {{ strtoupper($locale) }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
        {!! $mainMenu->asUl() !!}
    </nav>
    <div class="colorlib-footer">
        <h1 id="colorlib-logo" class="mb-4">
            @if (app()->getLocale() == request()->path())
                <a style="background-image: url(/images/logo_background.png);">
                    Site<span>Name</span>
                </a>
            @else
                <a href="/{{ app()->getLocale()}}"
                   style="background-image: url(/images/logo_background.png);">
                    Site<span>Name</span>
                </a>
            @endif
        </h1>
        <div class="auth">
            @guest
                <a href="{{ route('login', app()->getLocale()) }}">{{ __('auth.login') }}</a>
                @if (Route::has('register'))
                    / <a href="{{ route('register', app()->getLocale()) }}">{{ __('auth.register') }}</a>
                @endif
            @else
                <div class="dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"
                        href="{{ url('/' . app()->getLocale() . '/user', ['id' => Auth::user()->id]) }}"
                    >
                        <i class="fas fa-user"></i> Personal
                    </a>
                    <a class="dropdown-item" href="{{ route('logout', app()->getLocale()) }}"
                       onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                </div>
            @endguest
        </div>
        <div class="mb-4">
            <h3>{{__('blog.subscribe')}}</h3>
            <subscribe-horizontal></subscribe-horizontal>
        </div>
        <p class="pfooter">
            {{__('blog.copyright')}} &copy;{{ date('Y') }}
        </p>
    </div>
</aside>
