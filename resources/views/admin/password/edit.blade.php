@extends('layouts.admin')

@section('title', 'تغییر رمز عبور')

@section('content')

  <h1 class="admin-heading">تغییر رمز عبور</h1>

  <div class="admin-card">
    <form method="POST" action="{{ route('admin.password.update') }}" class="form-grid">
      @csrf
      @method('PUT')

      <div class="form-field">
        <label for="current_password">رمز عبور فعلی</label>
        <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
        @error('current_password')<p class="field-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-field">
        <label for="password">رمز عبور جدید</label>
        <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password">
        <p class="field-hint">حداقل ۸ کاراکتر.</p>
        @error('password')<p class="field-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-field">
        <label for="password_confirmation">تکرار رمز عبور جدید</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn--primary">ذخیره رمز عبور جدید</button>
      </div>
    </form>
  </div>

@endsection
