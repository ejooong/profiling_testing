<?php

return [
    'name' => env('SITE_NAME', 'NasDem Bojonegoro'),
    'description' => env('SITE_DESCRIPTION', 'Website Resmi Partai NasDem Kabupaten Bojonegoro'),
    'logo' => env('SITE_LOGO', null),
    'favicon' => env('SITE_FAVICON', null),
    
    'contact' => [
        'email' => env('CONTACT_EMAIL', 'info@nasdem-bojonegoro.id'),
        'phone' => env('CONTACT_PHONE', '(0353) 123456'),
        'address' => env('CONTACT_ADDRESS', 'Jl. Raya Bojonegoro No. 123, Kabupaten Bojonegoro, Jawa Timur'),
    ],
    
    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK', 'https://facebook.com/nasdembojonegoro'),
        'instagram' => env('SOCIAL_INSTAGRAM', 'https://instagram.com/nasdembojonegoro'),
        'twitter' => env('SOCIAL_TWITTER', 'https://twitter.com/nasdembojonegoro'),
        'youtube' => env('SOCIAL_YOUTUBE', 'https://youtube.com/nasdembojonegoro'),
        'whatsapp' => env('SOCIAL_WHATSAPP', 'https://wa.me/6281234567890'),
    ],
    
    'seo' => [
        'title' => env('SEO_TITLE', 'NasDem Bojonegoro - Website Resmi Partai NasDem Kabupaten Bojonegoro'),
        'keywords' => env('SEO_KEYWORDS', 'nasdem, bojonegoro, partai politik, kader, berita politik'),
        'description' => env('SEO_DESCRIPTION', 'Website resmi Partai NasDem Kabupaten Bojonegoro. Informasi kegiatan, berita, dan program kerja partai.'),
    ],
    
    'features' => [
        'news' => env('FEATURE_NEWS', true),
        'gallery' => env('FEATURE_GALLERY', true),
        'kader_registration' => env('FEATURE_KADER_REGISTRATION', true),
        'membership_check' => env('FEATURE_MEMBERSHIP_CHECK', true),
        'gis_map' => env('FEATURE_GIS_MAP', true),
    ],
    
    'app' => [
        'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),
        'locale' => env('APP_LOCALE', 'id'),
        'maintenance' => env('APP_MAINTENANCE', false),
    ],
];