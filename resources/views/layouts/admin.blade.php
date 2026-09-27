<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'مدیریت') | {{ config('restaurant.name') }}</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@vite(['resources/css/app.css'])
</head>
<body>

<svg style="display:none" xmlns:xlink="http://www.w3.org/1999/xlink">
  <symbol id="icon-plate" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/></symbol>
</svg>

<header class="admin-topbar">
  <span class="brand-name">{{ config('restaurant.name') }} — مدیریت</span>
  <nav class="admin-nav">
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">داشبورد</a>
    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">غذاها</a>
    <a href="{{ route('admin.menu.edit') }}" class="{{ request()->routeIs('admin.menu.*') ? 'is-active' : '' }}">منوی امروز</a>
    <a href="{{ route('home') }}" target="_blank" rel="noopener">مشاهده سایت ↗</a>
  </nav>
  <div class="row-actions">
    <a href="{{ route('admin.password.edit') }}" class="admin-logout-btn {{ request()->routeIs('admin.password.*') ? 'is-active' : '' }}">تغییر رمز عبور</a>
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit" class="admin-logout-btn">خروج</button>
    </form>
  </div>
</header>

<main class="admin-main">
  @if (session('status'))
    <div class="admin-status">{{ session('status') }}</div>
  @endif

  @yield('content')
</main>

</body>
</html>
