<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

    {{-- Static pages --}}
    @foreach(['az','en','ru'] as $lang)
    <url>
        <loc>{{ url($lang) }}</loc>
        <xhtml:link rel="alternate" hreflang="az" href="{{ url('az') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('en') }}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{ url('ru') }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('az') }}"/>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach

    @foreach(['az','en','ru'] as $lang)
    <url>
        <loc>{{ url($lang . '/haqqimizda') }}</loc>
        <xhtml:link rel="alternate" hreflang="az" href="{{ url('az/haqqimizda') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('en/haqqimizda') }}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{ url('ru/haqqimizda') }}"/>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    @foreach(['az','en','ru'] as $lang)
    <url>
        <loc>{{ url($lang . '/elaqe') }}</loc>
        <xhtml:link rel="alternate" hreflang="az" href="{{ url('az/elaqe') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('en/elaqe') }}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{ url('ru/elaqe') }}"/>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

    {{-- Services --}}
    @foreach($services as $item)
    <url>
        <loc>{{ url('az/xidmetler/' . $item->getTranslation('slug','az')) }}</loc>
        <xhtml:link rel="alternate" hreflang="az" href="{{ url('az/xidmetler/' . $item->getTranslation('slug','az')) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('en/xidmetler/' . ($item->getTranslation('slug','en') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{ url('ru/xidmetler/' . ($item->getTranslation('slug','ru') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('az/xidmetler/' . $item->getTranslation('slug','az')) }}"/>
        <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>
    @endforeach

    {{-- Blog --}}
    @foreach($blogs as $item)
    <url>
        <loc>{{ url('az/bloq/' . $item->getTranslation('slug','az')) }}</loc>
        <xhtml:link rel="alternate" hreflang="az" href="{{ url('az/bloq/' . $item->getTranslation('slug','az')) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('en/bloq/' . ($item->getTranslation('slug','en') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{ url('ru/bloq/' . ($item->getTranslation('slug','ru') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('az/bloq/' . $item->getTranslation('slug','az')) }}"/>
        <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Portfolio --}}
    @foreach($portfolio as $item)
    <url>
        <loc>{{ url('az/portfolio/' . $item->getTranslation('slug','az')) }}</loc>
        <xhtml:link rel="alternate" hreflang="az" href="{{ url('az/portfolio/' . $item->getTranslation('slug','az')) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('en/portfolio/' . ($item->getTranslation('slug','en') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{ url('ru/portfolio/' . ($item->getTranslation('slug','ru') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('az/portfolio/' . $item->getTranslation('slug','az')) }}"/>
        <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Boxes --}}
    @foreach($boxes as $item)
    <url>
        <loc>{{ url('az/qutular/' . $item->getTranslation('slug','az')) }}</loc>
        <xhtml:link rel="alternate" hreflang="az" href="{{ url('az/qutular/' . $item->getTranslation('slug','az')) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('en/qutular/' . ($item->getTranslation('slug','en') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{ url('ru/qutular/' . ($item->getTranslation('slug','ru') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('az/qutular/' . $item->getTranslation('slug','az')) }}"/>
        <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Campaigns --}}
    @foreach($campaigns as $item)
    <url>
        <loc>{{ url('az/kampaniyalar/' . $item->getTranslation('slug','az')) }}</loc>
        <xhtml:link rel="alternate" hreflang="az" href="{{ url('az/kampaniyalar/' . $item->getTranslation('slug','az')) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('en/kampaniyalar/' . ($item->getTranslation('slug','en') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{ url('ru/kampaniyalar/' . ($item->getTranslation('slug','ru') ?: $item->getTranslation('slug','az'))) }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('az/kampaniyalar/' . $item->getTranslation('slug','az')) }}"/>
        <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

</urlset>
