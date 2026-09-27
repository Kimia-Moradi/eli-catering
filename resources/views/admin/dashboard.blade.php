@extends('layouts.admin')

@section('title', 'داشبورد')

@section('content')

  <h1 class="admin-heading">خوش آمدید</h1>

  <div class="admin-stats">
    <div class="admin-stat">
      <strong class="en">{{ $productCount }}</strong>
      <span>غذای فعال</span>
    </div>
    <div class="admin-stat">
      <strong class="en">{{ $unavailableCount }}</strong>
      <span>غذای ناموجود</span>
    </div>
    <div class="admin-stat">
      <strong class="en">{{ $activeMenuItemCount }}</strong>
      <span>آیتم در منوی امروز</span>
    </div>
  </div>

  @unless ($hasActiveMenu)
    <div class="admin-card">
      <p style="margin-block-end: var(--space-2);">
        در حال حاضر هیچ منویی به عنوان منوی فعال سایت انتخاب نشده — صفحه‌ی عمومی سایت خالی نمایش داده می‌شود.
      </p>
      <a href="{{ route('admin.menu.edit') }}" class="btn btn--primary btn--sm">تنظیم منوی امروز</a>
    </div>
  @endunless

  <div class="admin-card">
    <p style="margin-block-end: var(--space-2); font-weight: 600;">دسترسی سریع</p>
    <div class="row-actions">
      <a href="{{ route('admin.products.create') }}" class="btn btn--primary btn--sm">افزودن غذای جدید</a>
      <a href="{{ route('admin.products.index') }}" class="btn btn--outline btn--sm">مدیریت غذاها</a>
      <a href="{{ route('admin.menu.edit') }}" class="btn btn--outline btn--sm">مدیریت منوی امروز</a>
    </div>
  </div>

@endsection
