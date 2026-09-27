<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>دسترسی غیرمجاز | {{ config('restaurant.name') }}</title>
@vite(['resources/css/app.css'])
<style>
  body { min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 2rem; }
  .error-box { max-width: 420px; }
  .error-box .code { font-family: var(--font-en-display); font-size: 3.5rem; color: var(--color-light-green); font-weight: 700; }
  .error-box h1 { font-family: var(--font-fa-display); color: var(--color-primary-green); font-size: 1.3rem; margin-block: .5rem 1rem; }
  .error-box p { color: var(--color-brown); margin-block-end: 1.5rem; }
</style>
</head>
<body>
  <div class="error-box">
    <div class="code en">403</div>
    <h1>دسترسی غیرمجاز</h1>
    <p>شما اجازه‌ی دسترسی به این بخش را ندارید.</p>
    <a href="{{ route('home') }}" class="btn btn--primary">بازگشت به صفحه اصلی</a>
  </div>
</body>
</html>
