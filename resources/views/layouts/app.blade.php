<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', config('restaurant.name').' | منوی امروز')</title>
<meta name="description" content="منوی روزانه {{ config('restaurant.name') }}؛ غذاهای خانگی تازه، سفارش با تماس تلفنی یا واتساپ.">
<meta property="og:title" content="{{ config('restaurant.name') }} | منوی امروز">
<meta property="og:description" content="غذاهای روزانه با مواد اولیه تازه و دستورهای خانگی، با عشق برای شما آماده می‌شوند.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@if (config('restaurant.hero_image_path'))
  <meta property="og:image" content="{{ Illuminate\Support\Facades\Storage::disk('public')->url(config('restaurant.hero_image_path')) }}">
@endif
<link rel="canonical" href="{{ url()->current() }}">
<meta name="theme-color" content="#556B2F">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Ccircle cx='12' cy='12' r='12' fill='%23556B2F'/%3E%3Cpath d='M12 5c-2 0-3.4 1.4-3.4 3.1 0 .4.1.8.2 1.1C7.3 9.7 6 11.1 6 12.8c0 .9.4 1.8 1 2.4V18h10v-2.8c.6-.6 1-1.5 1-2.4 0-1.7-1.3-3.1-2.8-3.6.1-.3.2-.7.2-1.1C15.4 6.4 14 5 12 5z' fill='%23F7F3E9'/%3E%3C/svg%3E">

{{-- Persian fonts: Peyda Bold + IRANSansX are the spec'd (licensed) fonts.
     Vazirmatn stands in until the real font files/kit are available — see
     the README. Swap the link below and the --font-fa-* variables in
     resources/css/app.css; nothing else needs to change. --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- Reusable icon sprite — defined once, referenced with <use> throughout. --}}
<svg style="display:none" xmlns:xlink="http://www.w3.org/1999/xlink">
  <symbol id="icon-phone" viewBox="0 0 24 24"><path d="M4 4.5c0-.8.6-1.5 1.4-1.5H8l1.8 4.5-2 1.6a12.3 12.3 0 0 0 6.1 6.1l1.6-2 4.5 1.8v2.6c0 .8-.7 1.4-1.5 1.4C10.6 19 5 13.4 4 6z"/></symbol>
  <symbol id="icon-whatsapp" viewBox="0 0 24 24"><path d="M6.5 17.5 4 20l2.6-.7A8 8 0 1 0 4 12a8 8 0 0 0 2.5 5.5Z"/><path d="M9 9.6c0 3 2.4 5.4 5.4 5.4.4 0 .8-.4.8-.9v-.9l-2-1-1 1a6 6 0 0 1-2.4-2.4l1-1-1-2h-.9c-.5 0-.9.4-.9.8Z"/></symbol>
  <symbol id="icon-instagram" viewBox="0 0 24 24"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17" cy="7" r="1" fill="currentColor" stroke="none"/></symbol>
  <symbol id="icon-cloche" viewBox="0 0 24 24"><path d="M4 16.5a8 8 0 0 1 16 0"/><line x1="2.5" y1="16.5" x2="21.5" y2="16.5"/><line x1="6" y1="19.5" x2="18" y2="19.5"/><path d="M10.5 5.2c-1.1.5-1.1 1.6 0 2.1" stroke-width="1.3"/><path d="M13.3 4.6c-1.1.5-1.1 1.6 0 2.1" stroke-width="1.3"/></symbol>
  <symbol id="icon-leaf" viewBox="0 0 24 24"><path d="M20 4C10 4 4 10 4 18c0 .6.4 1 1 1 8 0 14-6 14-15 0-.6-.4-1-1-1Z"/><path d="M6 18c3-4 7-7 12-9"/></symbol>
  <symbol id="icon-chef-hat" viewBox="0 0 24 24"><path d="M12 3c-2 0-3.4 1.4-3.4 3.1 0 .4.1.8.2 1.1C7.3 7.7 6 9.1 6 10.8c0 .9.4 1.8 1 2.4V17h10v-3.8c.6-.6 1-1.5 1-2.4 0-1.7-1.3-3.1-2.8-3.6.1-.3.2-.7.2-1.1C15.4 4.4 14 3 12 3Z"/><line x1="6" y1="19.5" x2="18" y2="19.5"/></symbol>
  <symbol id="icon-house-heart" viewBox="0 0 24 24"><path d="M4 11 12 4l8 7v7.5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1z"/><path d="M12 16.8s-2.8-1.7-2.8-3.5a1.6 1.6 0 0 1 2.8-1 1.6 1.6 0 0 1 2.8 1c0 1.8-2.8 3.5-2.8 3.5Z" fill="currentColor" stroke="none"/></symbol>
  <symbol id="icon-shield-check" viewBox="0 0 24 24"><path d="M12 3.3 18.5 5.8v5.3c0 4.7-2.8 7.6-6.5 8.6-3.7-1-6.5-3.9-6.5-8.6V5.8z"/><path d="M8.7 12l2.3 2.3 4.5-4.6"/></symbol>
  <symbol id="icon-clock-fast" viewBox="0 0 24 24"><circle cx="14.5" cy="12" r="7"/><path d="M14.5 8.2v4l2.8 1.8"/><line x1="1.5" y1="9" x2="5" y2="9"/><line x1="1.5" y1="12" x2="4" y2="12"/><line x1="1.5" y1="15" x2="5" y2="15"/></symbol>
  <symbol id="icon-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></symbol>
  <symbol id="icon-menu" viewBox="0 0 24 24"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></symbol>
  <symbol id="icon-close" viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></symbol>
  <symbol id="icon-plate" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/></symbol>
  <symbol id="icon-branch" viewBox="0 0 100 100"><path d="M10 90C10 50 40 20 90 10" stroke-width="1.5"/><path d="M25 75c8-4 14-10 16-18M42 58c8-3 14-8 17-15M60 42c7-3 12-7 15-13" stroke-width="1.5"/></symbol>
</svg>

@include('partials.site-header')

<main id="top">
@yield('content')
</main>

@include('partials.site-footer')

</body>
</html>
