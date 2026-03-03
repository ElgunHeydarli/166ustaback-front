<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', \App\Models\Setting::get('meta_title', '166 Usta'))</title>
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', ''))">
    <meta name="keywords"    content="@yield('meta_keywords',    \App\Models\Setting::get('meta_keywords', ''))">
    <meta name="robots"      content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">

    {{-- Pagination prev/next --}}
    @stack('head_links')

    {{-- OG Tags --}}
    <meta property="og:title"       content="@yield('title', \App\Models\Setting::get('meta_title', '166 Usta'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', ''))">
    @php
        $_ogImg = trim($__env->yieldContent('og_image') ?? '');
        if (!$_ogImg && \App\Models\Setting::get('og_image')) {
            $_ogImg = \Illuminate\Support\Facades\Storage::url(\App\Models\Setting::get('og_image'));
        }
        $_ogLocale = ['az' => 'az_AZ', 'en' => 'en_US', 'ru' => 'ru_RU'][app()->getLocale()] ?? 'az_AZ';
    @endphp
    @if($_ogImg)
    <meta property="og:image"        content="{{ $_ogImg }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"    content="@yield('title', \App\Models\Setting::get('meta_title', '166 Usta'))">
    @endif
    <meta property="og:site_name"    content="{{ \App\Models\Setting::get('site_name', '166 Usta') }}">

    {{-- Favicon --}}
    @if(\App\Models\Setting::get('site_favicon'))
    <link rel="icon" href="{{ Storage::url(\App\Models\Setting::get('site_favicon')) }}">
    @endif
    <meta name="theme-color" content="#ff6b35">
    @if(\App\Models\Setting::get('site_logo'))
    <link rel="apple-touch-icon" href="{{ Storage::url(\App\Models\Setting::get('site_logo')) }}">
    @endif

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Hreflang --}}
    @php
        $_hrefs = $hreflangUrls ?? null;
        if (!$_hrefs) {
            $_p = request()->path();
            $_hrefs = [];
            foreach (['az','en','ru'] as $_l) {
                $_hrefs[$_l] = url(preg_replace('/^(az|en|ru)(\/|$)/', $_l . '$2', $_p));
            }
        }
    @endphp
    <link rel="alternate" hreflang="az"        href="{{ $_hrefs['az'] ?? url('az') }}">
    <link rel="alternate" hreflang="en"        href="{{ $_hrefs['en'] ?? url('en') }}">
    <link rel="alternate" hreflang="ru"        href="{{ $_hrefs['ru'] ?? url('ru') }}">
    <link rel="alternate" hreflang="x-default" href="{{ $_hrefs['az'] ?? url('az') }}">

    {{-- OG extras --}}
    <meta property="og:url"    content="{{ url()->current() }}">
    <meta property="og:type"   content="@yield('og_type', 'website')">
    <meta property="og:locale" content="{{ $_ogLocale }}">
    @stack('og_extras')

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('title', \App\Models\Setting::get('meta_title', '166 Usta'))">
    <meta name="twitter:description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', ''))">
    @if($_ogImg)
    <meta name="twitter:image" content="{{ $_ogImg }}">
    @endif

    {{-- Google Search Console --}}
    @if(\App\Models\Setting::get('google_verification'))
    <meta name="google-site-verification" content="{{ \App\Models\Setting::get('google_verification') }}">
    @endif

    {{-- GTM (head) --}}
    @if(\App\Models\Setting::get('google_tag_manager'))
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ \App\Models\Setting::get('google_tag_manager') }}');</script>
    @endif

    {{-- GA4 --}}
    @if(\App\Models\Setting::get('google_analytics'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ \App\Models\Setting::get('google_analytics') }}"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ \App\Models\Setting::get('google_analytics') }}');</script>
    @endif

    {{-- Preconnect / DNS-prefetch --}}
    @if(\App\Models\Setting::get('google_tag_manager') || \App\Models\Setting::get('google_analytics'))
    <link rel="preconnect"  href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    @endif
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/style/style.css') }}" />

    @stack('styles')
</head>
<body>
    {{-- GTM (noscript) --}}
    @if(\App\Models\Setting::get('google_tag_manager'))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ \App\Models\Setting::get('google_tag_manager') }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    @php
        $locale   = app()->getLocale();
        $phone    = \App\Models\Setting::get('phone', '');
        $phone2   = \App\Models\Setting::get('phone2', '');
        $email    = \App\Models\Setting::get('email', '');
        $logo        = \App\Models\Setting::get('site_logo', '');
        $socialLinks = \App\Models\SocialLink::where('is_active', true)->orderBy('order')->get();

        $menuServices = \App\Models\Service::where('is_active', true)->where('show_in_menu', true)->orderBy('order')->get();
        $menuBoxes    = \App\Models\Box::where('is_active', true)->orderBy('order')->get();

        $langs = ['az' => 'Azərbaycan dili', 'en' => 'English', 'ru' => 'Русский'];
        $otherLangs = array_filter($langs, fn($k) => $k !== $locale, ARRAY_FILTER_USE_KEY);
    @endphp

    {{-- TOP HEADER --}}
    <header class="p-lr">
        <div class="header-container">
            <div class="header-links">
                <a href="{{ route('home', $locale) }}" class="header-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    {{ __('nav.home') }}
                </a>
                <a href="{{ route('about', $locale) }}" class="header-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    {{ __('nav.about') }}
                </a>
                <a href="{{ route('portfolio.index', $locale) }}" class="header-link {{ request()->routeIs('portfolio.*') ? 'active' : '' }}">
                    {{ __('nav.portfolio') }}
                </a>
                <a href="{{ route('blog.index', $locale) }}" class="header-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    {{ __('nav.blog') }}
                </a>
                <a href="{{ route('contact', $locale) }}" class="header-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                    {{ __('nav.contact') }}
                </a>
            </div>
            <div class="header-right">
                @if($phone)
                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="header-contact">
                    <div class="icon"><img src="{{ asset('frontend/icons/phoneOrange.svg') }}" alt=""></div>
                    <p>{{ $phone }}</p>
                </a>
                @endif
                @if($email)
                <a href="mailto:{{ $email }}" class="header-contact">
                    <div class="icon"><img src="{{ asset('frontend/icons/mailOrange.svg') }}" alt=""></div>
                    <p>{{ $email }}</p>
                </a>
                @endif
                <div class="language">
                    <button class="lang-btn" type="button">
                        <img src="{{ asset('frontend/icons/earthOrange.svg') }}" alt="" class="earthIcon" />
                        <p>{{ $langs[$locale] }}</p>
                        <img src="{{ asset('frontend/icons/arrowDownBlack.svg') }}" alt="" class="downIcon" />
                    </button>
                    <div class="other-languages">
                        @foreach($otherLangs as $langCode => $langName)
                        <a href="{{ url($langCode) }}" class="lang-item">{{ $langName }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- NAVBAR --}}
    <nav class="p-lr">
        <div class="navbar-container">
            <a href="{{ route('home', $locale) }}" class="logo">
                @if($logo)
                    <img src="{{ Storage::url($logo) }}" alt="{{ \App\Models\Setting::get('site_name', '166 Usta') }}">
                @else
                    <img src="{{ asset('frontend/images/logo.svg') }}" alt="166 Usta">
                @endif
            </a>
            <div class="navbar-links">
                {{-- Usta xidmətləri --}}
                <div class="link-menu">
                    <a href="{{ route('services.index', $locale) }}" class="menu-main-link">
                        {{ __('nav.services') }}
                        <img src="{{ asset('frontend/icons/arrowDownBlack.svg') }}" alt="">
                    </a>
                    @if($menuServices->isNotEmpty())
                    <div class="sub-menu">
                        @foreach($menuServices as $srv)
                        <a href="{{ route('services.show', [$locale, $srv->getTranslation('slug', $locale)]) }}" class="sub-menu-link">
                            {{ $srv->getTranslation('title', $locale) }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Qutular --}}
                <div class="link-menu">
                    <a href="{{ route('boxes.index', $locale) }}" class="menu-main-link">
                        {{ __('nav.boxes') }}
                        <img src="{{ asset('frontend/icons/arrowDownBlack.svg') }}" alt="">
                    </a>
                    @if($menuBoxes->isNotEmpty())
                    <div class="sub-menu">
                        @foreach($menuBoxes as $box)
                        <a href="{{ route('boxes.show', [$locale, $box->getTranslation('slug', $locale)]) }}" class="sub-menu-link">
                            {{ $box->getTranslation('title', $locale) }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Kampaniyalar --}}
                <a href="{{ route('campaigns.index', $locale) }}" class="navbar-link {{ request()->routeIs('campaigns.*') ? 'active' : '' }}">
                    {{ __('nav.campaigns') }}
                </a>
            </div>

            <a href="{{ route('contact', $locale) }}" class="nav-contact">
                <p>{{ __('nav.contact_us') }}</p>
                <img src="{{ asset('frontend/icons/phoneWhite.svg') }}" alt="">
            </a>
            <button class="hamburger" type="button">
                <img src="{{ asset('frontend/icons/hamburger.svg') }}" alt="">
            </button>
        </div>
    </nav>

    {{-- MOBİL MENYU --}}
    <section class="mobileMenu-overlay">
        <div class="mobileMenu">
            <div class="mobileMenu-head">
                <a href="{{ route('home', $locale) }}" class="logo">
                    @if($logo)
                        <img src="{{ Storage::url($logo) }}" alt="166 Usta">
                    @else
                        <img src="{{ asset('frontend/images/logo.svg') }}" alt="166 Usta">
                    @endif
                </a>
                <button class="closeMenu" type="button">
                    <img src="{{ asset('frontend/icons/closeOrange.svg') }}" alt="">
                </button>
            </div>
            <div class="mobile-lang">
                @foreach($langs as $langCode => $langName)
                <a href="{{ url($langCode) }}" class="mobile-lang-item {{ $langCode === $locale ? 'active' : '' }}">{{ strtoupper($langCode) }}</a>
                @if(!$loop->last)<span class="seperate"></span>@endif
                @endforeach
            </div>
            <div class="mobileMenu-links">
                <a href="{{ route('home', $locale) }}"           class="mobileMenu-link">{{ __('nav.home') }}</a>
                <a href="{{ route('about', $locale) }}"          class="mobileMenu-link">{{ __('nav.about') }}</a>
                <a href="{{ route('portfolio.index', $locale) }}" class="mobileMenu-link">{{ __('nav.portfolio') }}</a>
                <a href="{{ route('blog.index', $locale) }}"     class="mobileMenu-link">{{ __('nav.blog') }}</a>
                <a href="{{ route('campaigns.index', $locale) }}" class="mobileMenu-link">{{ __('nav.campaigns') }}</a>

                <div class="link-menu">
                    <div class="menu-main">
                        <a href="{{ route('services.index', $locale) }}" class="main-link">{{ __('nav.services') }}</a>
                        <button class="menu-drop-btn" type="button">
                            <img src="{{ asset('frontend/icons/arrowDownBlack.svg') }}" alt="">
                        </button>
                    </div>
                    <div class="menu-subMenu">
                        @foreach($menuServices as $srv)
                        <a href="{{ route('services.show', [$locale, $srv->getTranslation('slug', $locale)]) }}" class="subMenu-link">
                            {{ $srv->getTranslation('title', $locale) }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="link-menu">
                    <div class="menu-main">
                        <a href="{{ route('boxes.index', $locale) }}" class="main-link">{{ __('nav.boxes') }}</a>
                        <button class="menu-drop-btn" type="button">
                            <img src="{{ asset('frontend/icons/arrowDownBlack.svg') }}" alt="">
                        </button>
                    </div>
                    <div class="menu-subMenu">
                        @foreach($menuBoxes as $box)
                        <a href="{{ route('boxes.show', [$locale, $box->getTranslation('slug', $locale)]) }}" class="subMenu-link">
                            {{ $box->getTranslation('title', $locale) }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('contact', $locale) }}" class="mobileMenu-link">{{ __('nav.contact') }}</a>
            </div>
            <div class="mobileMenu-contact">
                @if($phone)
                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="mobileMenu-contact-item">
                    <div class="icon"><img src="{{ asset('frontend/icons/phoneOrange.svg') }}" alt=""></div>
                    <p>{{ $phone }}</p>
                </a>
                @endif
                @if($email)
                <a href="mailto:{{ $email }}" class="mobileMenu-contact-item">
                    <div class="icon"><img src="{{ asset('frontend/icons/mailOrange.svg') }}" alt=""></div>
                    <p>{{ $email }}</p>
                </a>
                @endif
            </div>
        </div>
    </section>

    {{-- ƏSAS MƏZMun --}}
    @yield('content')

    {{-- FOOTER --}}
    @php
        $address      = \App\Models\Setting::get('address', '');
        $workingHours = \App\Models\Setting::get('working_hours', '');
        $siteName     = \App\Models\Setting::get('site_name', '166 Usta');
        $lastBlogs    = \App\Models\BlogPost::where('is_active', true)->orderByDesc('published_at')->limit(5)->get();
    @endphp
    <footer>
        <div class="footer-container p-lr">
            <div class="footer-main">
                <div class="footer-logo-text">
                    <a href="{{ route('home', $locale) }}" class="logo">
                        @if($logo)
                            <img src="{{ Storage::url($logo) }}" alt="{{ $siteName }}">
                        @else
                            <img src="{{ asset('frontend/images/logo.svg') }}" alt="{{ $siteName }}">
                        @endif
                    </a>
                    <div class="footer-description">
                        <p>{{ \App\Models\Setting::get('site_tagline', '') }}</p>
                    </div>
                </div>

                <div class="quick-links">
                    <h2 class="quick-links-title">{{ __('footer.quick_links') }}</h2>
                    <div class="links">
                        <a href="{{ route('home', $locale) }}"            class="quick-link-item">{{ __('nav.home') }}</a>
                        <a href="{{ route('services.index', $locale) }}"  class="quick-link-item">{{ __('nav.services') }}</a>
                        <a href="{{ route('about', $locale) }}"           class="quick-link-item">{{ __('nav.about') }}</a>
                        <a href="{{ route('boxes.index', $locale) }}"     class="quick-link-item">{{ __('nav.boxes') }}</a>
                        <a href="{{ route('portfolio.index', $locale) }}" class="quick-link-item">{{ __('nav.portfolio') }}</a>
                        <a href="{{ route('campaigns.index', $locale) }}" class="quick-link-item">{{ __('nav.campaigns') }}</a>
                        <a href="{{ route('blog.index', $locale) }}"      class="quick-link-item">{{ __('nav.blog') }}</a>
                    </div>
                </div>

                <div class="last-blogs">
                    <h2 class="last-blogs-title">{{ __('footer.last_blogs') }}</h2>
                    <div class="links">
                        @foreach($lastBlogs as $post)
                        <a href="{{ route('blog.show', [$locale, $post->getTranslation('slug', $locale)]) }}" class="link-item">
                            {{ $post->getTranslation('title', $locale) }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="footer-contact">
                    <h2 class="footer-contact-title">{{ __('nav.contact') }}</h2>
                    <div class="footer-contact-items">
                        @if($phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="footer-contact-item">
                            <div class="icon"><img src="{{ asset('frontend/icons/phoneOrange.svg') }}" alt=""></div>
                            <p>{{ $phone }}</p>
                        </a>
                        @endif
                        @if($email)
                        <a href="mailto:{{ $email }}" class="footer-contact-item">
                            <div class="icon"><img src="{{ asset('frontend/icons/mailOrange.svg') }}" alt=""></div>
                            <p>{{ $email }}</p>
                        </a>
                        @endif
                        @if($address)
                        <div class="footer-contact-item">
                            <div class="icon"><img src="{{ asset('frontend/icons/locationOrange.svg') }}" alt=""></div>
                            <p>{{ $address }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="all-right-reserved">©{{ date('Y') }} | {{ $siteName }}. All rights reserved</p>
                <a href="{{ route('privacy', $locale) }}" class="privacy_policy">{{ __('footer.privacy') }}</a>
                <div class="socials">
                    @foreach($socialLinks as $sl)
                    <a href="{{ $sl->url }}" class="social-item" target="_blank" rel="noopener">
                        @if($sl->icon)
                            <img src="{{ Storage::url($sl->icon) }}" alt="{{ $sl->name }}" style="width:22px;height:22px;object-fit:contain;">
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <img src="{{ asset('frontend/images/footerVector.svg') }}" alt="" class="footerDecoration" />
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>
    <script src="{{ asset('frontend/swiper/swiper.js') }}"></script>
    <script src="{{ asset('frontend/js/index.js') }}"></script>
    @stack('scripts')

    {{-- LocalBusiness JSON-LD --}}
    @php
        $_ld = [
            '@context' => 'https://schema.org',
            '@type'    => 'LocalBusiness',
            '@id'      => url('/'),
            'name'     => \App\Models\Setting::get('site_name', '166 Usta'),
            'url'      => url('/az'),
        ];
        if ($_t = \App\Models\Setting::get('phone'))   $_ld['telephone'] = $_t;
        if ($_e = \App\Models\Setting::get('email'))   $_ld['email']     = $_e;
        if ($_a = \App\Models\Setting::get('address')) $_ld['address']   = ['@type'=>'PostalAddress','streetAddress'=>$_a,'addressLocality'=>'Bakı','addressCountry'=>'AZ'];
        if ($_lg = \App\Models\Setting::get('site_logo')) $_ld['logo']   = \Illuminate\Support\Facades\Storage::url($_lg);
    @endphp
    <script type="application/ld+json">{!! json_encode($_ld, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>

    {{-- WhatsApp Floating Button --}}
    @php $_wpFloat = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', \App\Models\Setting::get('phone', ''))); @endphp
    @if($_wpFloat)
    <a href="https://wa.me/{{ $_wpFloat }}" class="wp-float-btn" target="_blank" rel="noopener" aria-label="WhatsApp ilə əlaqə">
        <img src="{{ asset('frontend/icons/wp.svg') }}" alt="WhatsApp">
    </a>
    <style>
    .wp-float-btn{position:fixed;bottom:28px;right:28px;width:56px;height:56px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(37,211,102,.4);z-index:9990;transition:transform .2s,box-shadow .2s;text-decoration:none;}
    .wp-float-btn:hover{transform:scale(1.1);box-shadow:0 6px 28px rgba(37,211,102,.6);}
    .wp-float-btn img{width:28px;height:28px;filter:brightness(0) invert(1);}
    @media(max-width:768px){.wp-float-btn{bottom:20px;right:16px;width:50px;height:50px;} .wp-float-btn img{width:24px;height:24px;}}
    </style>
    @endif

    {{-- WebSite JSON-LD (Sitelinks SearchBox) --}}
    @php
        $_wsLD = [
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            'name'            => \App\Models\Setting::get('site_name', '166 Usta'),
            'url'             => url('/az'),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => url('/az/bloq') . '?search={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($_wsLD, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>

    @stack('schema')
</body>
</html>
