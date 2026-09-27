@extends('layouts.app')

@section('content')

  <section class="hero-section" aria-label="معرفی">
    <div class="container hero-container">
      <div class="hero-media">
        <div class="hero-image">
          @if (config('restaurant.hero_image_path'))
            <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url(config('restaurant.hero_image_path')) }}" alt="غذای {{ config('restaurant.name') }}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
          @else
            <svg class="icon" aria-hidden="true"><use href="#icon-plate" xlink:href="#icon-plate"/></svg>
            {{-- EDIT: hero photo — set RESTAURANT_HERO_IMAGE_PATH in .env once a real photo is uploaded --}}
          @endif
        </div>
      </div>
      <div class="hero-content">
        <h1 class="hero-title">طعم غذای خونگی، هر روز</h1>
        <p class="hero-description">غذاهای روزانه با مواد اولیه تازه و دستورهای خانگی، با عشق برای شما آماده می‌شوند.</p>
        <a class="hero-cta btn btn--primary" href="#menu">
          <svg class="icon" aria-hidden="true"><use href="#icon-leaf" xlink:href="#icon-leaf"/></svg>
          مشاهده منوی امروز
        </a>
      </div>
    </div>
  </section>

  <section class="menu-section" id="menu" aria-labelledby="menu-heading">
    <div class="container">
      <div class="section-heading-row">
        <svg class="icon" aria-hidden="true"><use href="#icon-leaf" xlink:href="#icon-leaf"/></svg>
        <h2 class="section-heading" id="menu-heading">منوی امروز</h2>
        <svg class="icon" aria-hidden="true" style="transform:scaleX(-1)"><use href="#icon-leaf" xlink:href="#icon-leaf"/></svg>
      </div>

      <ul class="menu-list">
        @forelse ($menuItems as $item)
          <li class="menu-item @if(!$item->product->is_available) menu-item--unavailable @endif">
            <div class="menu-item__image">
              @if ($item->product->image_url)
                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
              @else
                <svg class="icon" aria-hidden="true"><use href="#icon-plate" xlink:href="#icon-plate"/></svg>
              @endif
            </div>
            <div class="menu-item__content">
              <span class="menu-item__name">{{ $item->product->name }}</span>
              @unless ($item->product->is_available)
                <span class="menu-item__unavailable-tag">ناموجود</span>
              @endunless
              <span class="menu-item__separator" aria-hidden="true"></span>
              <span class="menu-item__price"><span class="en">{{ fa_number($item->product->formatted_price) }}</span> تومان</span>
            </div>
          </li>
        @empty
          {{-- Empty-menu state, per the spec's explicit error-handling requirement — this is not a broken page, just nothing published yet. --}}
          <li class="menu-item" style="justify-content:center; color:var(--color-brown);">
            منوی امروز هنوز تنظیم نشده است — به‌زودی برمی‌گردیم.
          </li>
        @endforelse
      </ul>

      @if (config('restaurant.order_hours'))
        <p class="menu-hours">
          <svg class="icon" aria-hidden="true"><use href="#icon-clock" xlink:href="#icon-clock"/></svg>
          ساعت سفارش: {{ fa_number(config('restaurant.order_hours')) }}
        </p>
      @endif
    </div>
  </section>

  <section class="ordering-section" id="contact" aria-labelledby="order-heading">
    <div class="container">
      <div class="section-heading-row">
        <svg class="icon" aria-hidden="true"><use href="#icon-leaf" xlink:href="#icon-leaf"/></svg>
        <h2 class="section-heading" id="order-heading">سفارش آسان</h2>
      </div>
      <p class="order-description">سفارش خود را از طریق واتساپ یا تماس تلفنی ثبت کنید</p>
      <div class="order-actions">
        <a class="whatsapp-order-button btn btn--primary" href="https://wa.me/{{ ltrim(config('restaurant.whatsapp'), '+') }}" target="_blank" rel="noopener">
          <svg class="icon" aria-hidden="true"><use href="#icon-whatsapp" xlink:href="#icon-whatsapp"/></svg>
          سفارش از واتساپ
        </a>
        <a class="phone-order-button btn btn--outline" href="tel:{{ config('restaurant.phone') }}">
          <svg class="icon" aria-hidden="true"><use href="#icon-phone" xlink:href="#icon-phone"/></svg>
          تماس تلفنی
        </a>
      </div>
    </div>
  </section>

  <section class="benefits-section" id="about" aria-label="ویژگی‌های ما">
    <div class="container">
      <div class="benefits-card">
        <ul class="benefits-list">
          <li class="benefit-item">
            <span class="icon-wrap"><svg class="icon" aria-hidden="true"><use href="#icon-cloche" xlink:href="#icon-cloche"/></svg></span>
            <p>غذای تازه</p>
          </li>
          <li class="benefit-item">
            <span class="icon-wrap"><svg class="icon" aria-hidden="true"><use href="#icon-leaf" xlink:href="#icon-leaf"/></svg></span>
            <p>مواد اولیه با کیفیت</p>
          </li>
          <li class="benefit-item">
            <span class="icon-wrap"><svg class="icon" aria-hidden="true"><use href="#icon-house-heart" xlink:href="#icon-house-heart"/></svg></span>
            <p>غذای خانگی با عشق</p>
          </li>
          <li class="benefit-item">
            <span class="icon-wrap"><svg class="icon" aria-hidden="true"><use href="#icon-shield-check" xlink:href="#icon-shield-check"/></svg></span>
            <p>بهداشتی و قابل اعتماد</p>
          </li>
          <li class="benefit-item">
            <span class="icon-wrap"><svg class="icon" aria-hidden="true"><use href="#icon-clock-fast" xlink:href="#icon-clock-fast"/></svg></span>
            <p>تحویل سریع</p>
          </li>
        </ul>
      </div>
    </div>
  </section>

@endsection
