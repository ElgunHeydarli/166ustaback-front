<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Frontend;

// ============================================================
// ADMIN ROUTES
// ============================================================

// Admin Auth (giriş icazəsi lazım deyil)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
});

// Admin Panel (giriş tələb olunur)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Parametrlər
    Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

    // CRUD bölümlər
    Route::resource('services', Admin\ServiceController::class)->except(['show']);
    Route::resource('portfolio', Admin\PortfolioController::class)->except(['show']);
    Route::resource('blog', Admin\BlogController::class)->except(['show']);
    Route::resource('blog-tags', Admin\BlogTagController::class)->except(['show']);
    Route::resource('boxes', Admin\BoxController::class)->except(['show']);
    Route::resource('campaigns', Admin\CampaignController::class)->except(['show']);
    Route::resource('partners', Admin\PartnerController::class)->except(['show']);
    Route::resource('social-links', Admin\SocialLinkController::class)->except(['show']);
    Route::resource('testimonials', Admin\TestimonialController::class)->except(['show']);
    Route::resource('sliders', Admin\SliderController::class)->except(['show']);

    // Əsas Səhifə — Haqqımızda
    Route::get('home-about', [Admin\HomeAboutController::class, 'edit'])->name('home-about.edit');
    Route::put('home-about', [Admin\HomeAboutController::class, 'update'])->name('home-about.update');

    // Haqqımızda — Niyə Biz
    Route::get('home-why-us', [Admin\HomeWhyUsController::class, 'edit'])->name('home-why-us.edit');
    Route::put('home-why-us', [Admin\HomeWhyUsController::class, 'update'])->name('home-why-us.update');

    // Əsas Səhifə — Sifariş CTA
    Route::get('home-cta', [Admin\HomeCtaController::class, 'edit'])->name('home-cta.edit');
    Route::put('home-cta', [Admin\HomeCtaController::class, 'update'])->name('home-cta.update');

    // Məxfilik siyasəti
    Route::get('privacy', [Admin\PrivacyController::class, 'edit'])->name('privacy.edit');
    Route::put('privacy', [Admin\PrivacyController::class, 'update'])->name('privacy.update');

    // Əlaqə mesajları (yalnız oxuma + sil)
    Route::get('messages', [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [Admin\ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');
});

// ============================================================
// FRONTEND ROUTES
// ============================================================
Route::redirect('/', '/az');

// SEO faylları
Route::get('/robots.txt', function () {
    $content = \App\Models\Setting::get('robots_txt', "User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml'));
    return response($content, 200)->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', [Frontend\SitemapController::class, 'index'])->name('sitemap');

Route::prefix('{locale}')
    ->where(['locale' => 'az|en|ru'])
    ->middleware('setlocale')
    ->group(function () {
        Route::get('/', [Frontend\HomeController::class, 'index'])->name('home');

        // Digər səhifələr sonra əlavə olunacaq
        Route::get('/haqqimizda',     [Frontend\PageController::class, 'about'])->name('about');
        Route::get('/elaqe',          [Frontend\PageController::class, 'contact'])->name('contact');
        Route::get('/mexfilik',       [Frontend\PageController::class, 'privacy'])->name('privacy');

        Route::get('/xidmetler',               [Frontend\ServiceController::class,  'index'])->name('services.index');
        Route::get('/xidmetler/{slug}',        [Frontend\ServiceController::class,  'show'])->name('services.show');

        Route::get('/portfolio',               [Frontend\PortfolioController::class,'index'])->name('portfolio.index');
        Route::get('/portfolio/{slug}',        [Frontend\PortfolioController::class,'show'])->name('portfolio.show');

        Route::get('/bloq',                    [Frontend\BlogController::class,     'index'])->name('blog.index');
        Route::get('/bloq/{slug}',             [Frontend\BlogController::class,     'show'])->name('blog.show');

        Route::get('/qutular',                 [Frontend\BoxController::class,      'index'])->name('boxes.index');
        Route::get('/qutular/{slug}',          [Frontend\BoxController::class,      'show'])->name('boxes.show');

        Route::get('/kampaniyalar',            [Frontend\CampaignController::class, 'index'])->name('campaigns.index');
        Route::get('/kampaniyalar/{slug}',     [Frontend\CampaignController::class, 'show'])->name('campaigns.show');

        Route::post('/elaqe',                  [Frontend\PageController::class,     'contactPost'])->name('contact.post');
    });
