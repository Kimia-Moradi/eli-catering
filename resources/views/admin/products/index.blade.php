@extends('layouts.admin')

@section('title', 'مدیریت غذاها')

@section('content')

  <div class="admin-heading-row">
    <h1 class="admin-heading">غذاها</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn--primary btn--sm">+ افزودن غذای جدید</a>
  </div>

  <div class="admin-card">
    @if ($products->isEmpty())
      <p class="empty-state">هنوز غذایی ثبت نشده. با «افزودن غذای جدید» شروع کنید.</p>
    @else
      <table class="admin-table">
        <thead>
          <tr>
            <th></th>
            <th>نام</th>
            <th>قیمت</th>
            <th>وضعیت</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $product)
            <tr>
              <td>
                @if ($product->image_url)
                  <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="thumb">
                @else
                  <span class="thumb-placeholder"><svg class="icon" aria-hidden="true"><use href="#icon-plate" xlink:href="#icon-plate"/></svg></span>
                @endif
              </td>
              <td>{{ $product->name }}</td>
              <td><span class="en">{{ number_format($product->price) }}</span> تومان</td>
              <td>
                @if ($product->is_available)
                  <span class="badge badge--available">موجود</span>
                @else
                  <span class="badge badge--unavailable">ناموجود</span>
                @endif
              </td>
              <td>
                <div class="row-actions">
                  <a href="{{ route('admin.products.edit', $product) }}" class="btn btn--outline btn--tiny">ویرایش</a>
                  <form method="POST" action="{{ route('admin.products.toggle-availability', $product) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn--outline btn--tiny">
                      {{ $product->is_available ? 'علامت‌گذاری ناموجود' : 'علامت‌گذاری موجود' }}
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('این غذا از منو و لیست غذاها حذف شود؟ (قابل بازگردانی است)');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn--danger btn--tiny">حذف</button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  @if ($inactiveProducts->isNotEmpty())
    <div class="admin-card">
      <p style="margin-block-end: var(--space-2); font-weight: 600; color: var(--color-brown);">غذاهای حذف‌شده</p>
      <table class="admin-table">
        <thead>
          <tr><th>نام</th><th>عملیات</th></tr>
        </thead>
        <tbody>
          @foreach ($inactiveProducts as $product)
            <tr>
              <td>{{ $product->name }}</td>
              <td>
                <form method="POST" action="{{ route('admin.products.restore', $product) }}">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn--outline btn--tiny">بازگردانی</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

@endsection
