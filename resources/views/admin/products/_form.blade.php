@csrf

@if ($product->exists && $product->image_url)
  <div class="current-image">
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
    <span>تصویر فعلی — در صورت انتخاب تصویر جدید، این تصویر جایگزین می‌شود.</span>
  </div>
@endif

<div class="form-grid">
  <div class="form-field">
    <label for="name">نام غذا</label>
    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
    @error('name')<p class="field-error">{{ $message }}</p>@enderror
  </div>

  <div class="form-field">
    <label for="description">توضیحات (اختیاری)</label>
    <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
    @error('description')<p class="field-error">{{ $message }}</p>@enderror
  </div>

  <div class="form-field">
    <label for="price">قیمت (تومان)</label>
    <input type="number" id="price" name="price" min="0" step="1000" value="{{ old('price', $product->price) }}" required>
    @error('price')<p class="field-error">{{ $message }}</p>@enderror
  </div>

  <div class="form-field">
    <label for="image">تصویر غذا</label>
    <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/webp">
    <p class="field-hint">فرمت مجاز: JPG، PNG یا WebP — حداکثر ۴ مگابایت.</p>
    @error('image')<p class="field-error">{{ $message }}</p>@enderror
  </div>

  <div class="form-field">
    <label class="checkbox-field">
      <input type="checkbox" name="is_available" value="1" {{ old('is_available', $product->exists ? $product->is_available : true) ? 'checked' : '' }}>
      در حال حاضر موجود است
    </label>
  </div>
</div>

<div class="form-actions">
  <button type="submit" class="btn btn--primary">{{ $product->exists ? 'ذخیره تغییرات' : 'افزودن غذا' }}</button>
  <a href="{{ route('admin.products.index') }}" class="btn btn--outline">انصراف</a>
</div>
