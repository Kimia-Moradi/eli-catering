<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ورود مدیریت | {{ config('restaurant.name') }}</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css'])
<style>
  body { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
  .login-card {
    width: 100%; max-width: 380px; background: var(--color-white);
    border: 1px solid var(--color-light-green); border-radius: var(--radius-md);
    padding: var(--space-4); box-shadow: var(--shadow-soft);
  }
  .login-card h1 { font-family: var(--font-fa-display); font-weight: 800; color: var(--color-primary-green); font-size: 1.4rem; text-align: center; margin-block-end: .3rem; }
  .login-card .subtitle { text-align: center; font-size: .85rem; color: var(--color-brown); margin-block-end: var(--space-3); }
  .field { margin-block-end: var(--space-2); }
  .field label { display: block; font-size: .85rem; font-weight: 600; margin-block-end: .35rem; }
  .field input[type="email"], .field input[type="password"] {
    width: 100%; padding: .65rem .9rem; border-radius: var(--radius-sm);
    border: 1.5px solid var(--color-light-green); font: inherit; background: var(--color-bg);
  }
  .field input:focus-visible { outline: 2px solid var(--color-primary-green); outline-offset: 1px; }
  .field-error { color: #a13a3a; font-size: .8rem; margin-block-start: .3rem; }
  .remember-row { display: flex; align-items: center; gap: .5rem; font-size: .85rem; margin-block-end: var(--space-3); }
  .login-card .btn { width: 100%; justify-content: center; }
  .status-banner {
    background: var(--color-light-green); color: var(--color-charcoal);
    padding: .6rem .9rem; border-radius: var(--radius-sm); font-size: .85rem;
    margin-block-end: var(--space-3); text-align: center;
  }
</style>
</head>
<body>
  <form class="login-card" method="POST" action="{{ url('/admin/login') }}" novalidate>
    @csrf

    <h1>ورود به پنل مدیریت</h1>
    <p class="subtitle">{{ config('restaurant.name') }}</p>

    @if (session('status'))
      <div class="status-banner">{{ session('status') }}</div>
    @endif

    <div class="field">
      <label for="email">ایمیل</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
      @error('email')
        <p class="field-error">{{ $message }}</p>
      @enderror
    </div>

    <div class="field">
      <label for="password">رمز عبور</label>
      <input id="password" type="password" name="password" required autocomplete="current-password">
      @error('password')
        <p class="field-error">{{ $message }}</p>
      @enderror
    </div>

    <label class="remember-row">
      <input type="checkbox" name="remember">
      مرا به خاطر بسپار
    </label>

    <button type="submit" class="btn btn--primary">ورود</button>
  </form>
</body>
</html>
