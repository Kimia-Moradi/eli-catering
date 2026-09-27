<?php

// Centralized restaurant-specific values. Every Blade view and controller
// reads from here (via config('restaurant.xxx')) instead of hardcoding these
// values — if the phone number changes, this is the only file to touch.
// Actual values come from .env so they can differ between environments
// without editing code.

return [

    'name' => env('RESTAURANT_NAME', 'Eli Catering'),

    // Stored in E.164-ish form (+98...) so it can be used directly in both
    // tel: and https://wa.me/ links. Blade formats it for display separately.
    'phone' => env('RESTAURANT_PHONE', '+989120000000'),
    'whatsapp' => env('RESTAURANT_WHATSAPP', '+989120000000'),

    'instagram_handle' => env('RESTAURANT_INSTAGRAM', 'eli.catering'),
    'instagram_url' => 'https://instagram.com/'.env('RESTAURANT_INSTAGRAM', 'eli.catering'),

    'address' => env('RESTAURANT_ADDRESS', ''),
    'order_hours' => env('RESTAURANT_ORDER_HOURS', '۱۰ صبح تا ۲ بعدازظهر'),

    // Set once a real production URL exists; used to generate the footer QR
    // code. Left null so the view can fall back to a decorative placeholder.
    'menu_url' => env('RESTAURANT_MENU_URL'),

    // Relative paths under storage/app/public. Left null until the real
    // assets exist — views check for null and fall back to the placeholder
    // treatment already built into the front-end.
    'logo_path' => env('RESTAURANT_LOGO_PATH'),
    'hero_image_path' => env('RESTAURANT_HERO_IMAGE_PATH'),
];
