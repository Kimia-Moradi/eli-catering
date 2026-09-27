<header class="site-header">
  <div class="header-container">
    {{-- EDIT: logo — replace this placeholder badge with the real logo file, or set config('restaurant.logo_path') and swap this <svg> for an <img>. --}}
    <a class="brand" href="#top" aria-label="{{ config('restaurant.name') }} — بازگشت به ابتدای صفحه">
      <svg class="logo" viewBox="0 0 44 44" role="img" aria-hidden="true">
        <circle cx="22" cy="22" r="21" fill="none" stroke="#556B2F" stroke-width="1.4"/>
        <use href="#icon-chef-hat" xlink:href="#icon-chef-hat" x="12" y="10" width="20" height="20" style="stroke:#556B2F; fill:none; stroke-width:1.4"/>
      </svg>
      <span class="brand-wordmark"><strong class="en">Eli</strong><span class="en">CATERING</span></span>
    </a>

    <nav class="primary-navigation" id="primary-navigation" aria-label="ناوبری اصلی">
      <a class="nav-link nav-link--active" href="#top">خانه</a>
      <a class="nav-link" href="#menu">منوی امروز</a>
      <a class="nav-link" href="#about">درباره ما</a>
      <a class="nav-link" href="#contact">تماس با ما</a>
    </nav>

    <div class="header-actions">
      <a class="phone-order-button btn btn--primary btn--sm" href="tel:{{ config('restaurant.phone') }}">
        <svg class="icon" aria-hidden="true"><use href="#icon-phone" xlink:href="#icon-phone"/></svg>
        سفارش تلفنی
      </a>
    </div>

    <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="mobileNavPanel" aria-label="باز کردن منوی ناوبری">
      <svg class="icon icon-menu" aria-hidden="true"><use href="#icon-menu" xlink:href="#icon-menu"/></svg>
      <svg class="icon icon-close" aria-hidden="true"><use href="#icon-close" xlink:href="#icon-close"/></svg>
    </button>
  </div>

  <div class="mobile-nav-panel" id="mobileNavPanel">
    <div class="container">
      <a class="nav-link nav-link--active" href="#top">خانه</a>
      <a class="nav-link" href="#menu">منوی امروز</a>
      <a class="nav-link" href="#about">درباره ما</a>
      <a class="nav-link" href="#contact">تماس با ما</a>
      <a class="phone-order-button btn btn--primary btn--sm" href="tel:{{ config('restaurant.phone') }}">
        <svg class="icon" aria-hidden="true"><use href="#icon-phone" xlink:href="#icon-phone"/></svg>
        سفارش تلفنی
      </a>
    </div>
  </div>
</header>
