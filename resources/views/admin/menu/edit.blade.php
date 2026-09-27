@extends('layouts.admin')

@section('title', 'مدیریت منوی امروز')

@section('content')

  <div class="admin-heading-row">
    <h1 class="admin-heading">منوی تاریخ <span class="en">{{ $menu->menu_date->format('Y-m-d') }}</span></h1>
    @unless ($menu->is_active)
      <form method="POST" action="{{ route('admin.menu.activate', $menu) }}">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn--primary btn--sm">تنظیم به عنوان منوی فعال سایت</button>
      </form>
    @else
      <span class="badge badge--available">در حال حاضر روی سایت فعال است</span>
    @endunless
  </div>

  <div class="row-actions" style="margin-block-end: var(--space-3); align-items: center;">
    <a href="{{ route('admin.menu.edit', ['date' => $previousDate]) }}" class="btn btn--outline btn--tiny">← روز قبل</a>
    @unless ($isToday)
      <a href="{{ route('admin.menu.edit') }}" class="btn btn--outline btn--tiny">امروز</a>
    @endunless
    <a href="{{ route('admin.menu.edit', ['date' => $nextDate]) }}" class="btn btn--outline btn--tiny">روز بعد ←</a>
    <form method="GET" action="{{ route('admin.menu.edit') }}" class="row-actions" style="align-items: center;">
      <input type="date" id="menuDatePicker" name="date" value="{{ $date }}" style="padding:.4rem .6rem; border-radius:var(--radius-sm); border:1.5px solid var(--color-light-green); font:inherit;">
      <button type="submit" class="btn btn--outline btn--tiny">برو</button>
    </form>
  </div>
  <p class="field-hint" style="margin-block-end: var(--space-3);">می‌توانید منوی چند روز آینده را از حالا آماده کنید — فقط تا زمانی که «تنظیم به عنوان منوی فعال» را نزنید، روی سایت نمایش داده نمی‌شود.</p>

  <div class="admin-card">
    @if ($menu->menuItems->isEmpty())
      <p class="empty-state">هنوز غذایی به این منو اضافه نشده.</p>
    @else
      <table class="admin-table">
        <thead>
          <tr>
            <th>ترتیب</th>
            <th>نام غذا</th>
            <th>قیمت</th>
            <th>وضعیت</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($menu->menuItems as $item)
            <tr>
              <td>
                {{-- Its own small form — a per-row save, not part of one giant form, so it can sit next to the remove form below without nesting. --}}
                <form method="POST" action="{{ route('admin.menu.items.order', $item) }}" class="row-actions">
                  @csrf @method('PATCH')
                  <input type="number" name="display_order" value="{{ $item->display_order }}" min="0" class="order-input">
                  <button type="submit" class="btn btn--outline btn--tiny">ذخیره</button>
                </form>
              </td>
              <td>{{ $item->product->name }}</td>
              <td><span class="en">{{ number_format($item->product->price) }}</span> تومان</td>
              <td>
                @if ($item->product->is_available)
                  <span class="badge badge--available">موجود</span>
                @else
                  <span class="badge badge--unavailable">ناموجود</span>
                @endif
              </td>
              <td>
                <form method="POST" action="{{ route('admin.menu.items.remove', $item) }}" onsubmit="return confirm('این غذا از منوی امروز حذف شود؟');">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn--danger btn--tiny">حذف از منو</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  <div class="admin-card">
    <p style="margin-block-end: var(--space-2); font-weight: 600;">افزودن غذا به این منو</p>
    @if ($availableProducts->isEmpty())
      <p class="field-hint">همه‌ی غذاهای فعال از قبل در این منو هستند. برای افزودن گزینه‌ی تازه، ابتدا از صفحه‌ی «غذاها» یک غذای جدید بسازید.</p>
    @else
      <form method="POST" action="{{ route('admin.menu.items.add') }}" class="row-actions">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
        <select name="product_id" required style="padding:.6rem .85rem; border-radius:var(--radius-sm); border:1.5px solid var(--color-light-green); font:inherit; background:var(--color-bg);">
          <option value="" disabled selected>یک غذا انتخاب کنید…</option>
          @foreach ($availableProducts as $product)
            <option value="{{ $product->id }}">{{ $product->name }} — {{ number_format($product->price) }} تومان</option>
          @endforeach
        </select>
        <button type="submit" class="btn btn--primary btn--sm">افزودن به منو</button>
      </form>
    @endif
  </div>

@endsection
