<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Longest side a stored product photo is allowed to be. Phone cameras
     * routinely produce 3000px+, multi-MB photos — the spec explicitly
     * calls for image optimization, not just a max-upload-size check.
     */
    private const MAX_DIMENSION = 1200;

    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::where('is_active', true)->latest()->get(),
            'inactiveProducts' => Product::where('is_active', false)->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', ['product' => new Product]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['is_available'] = $request->boolean('is_available', true);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeOptimizedImage($request->file('image'));
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'غذای جدید با موفقیت اضافه شد.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['is_available'] = $request->boolean('is_available', true);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $this->storeOptimizedImage($request->file('image'));
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'تغییرات ذخیره شد.');
    }

    /**
     * Resizes to a sane max dimension and re-encodes as JPEG at 82% quality
     * before storing. Uses GD (bundled with PHP — see composer.json's
     * ext-gd requirement) rather than pulling in Intervention Image for
     * one resize operation.
     */
    private function storeOptimizedImage(UploadedFile $file): string
    {
        $source = match ($file->getMimeType()) {
            'image/png' => imagecreatefrompng($file->getRealPath()),
            'image/webp' => imagecreatefromwebp($file->getRealPath()),
            default => imagecreatefromjpeg($file->getRealPath()),
        };

        $width = imagesx($source);
        $height = imagesy($source);

        if ($width > self::MAX_DIMENSION || $height > self::MAX_DIMENSION) {
            $ratio = min(self::MAX_DIMENSION / $width, self::MAX_DIMENSION / $height);
            $newWidth = max(1, (int) round($width * $ratio));
            $newHeight = max(1, (int) round($height * $ratio));

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $resized;
        }

        Storage::disk('public')->makeDirectory('products');
        $relativePath = 'products/'.Str::random(24).'.jpg';
        imagejpeg($source, Storage::disk('public')->path($relativePath), 82);
        imagedestroy($source);

        return $relativePath;
    }

    /**
     * "Remove" a product without ever hard-deleting it — see the products
     * migration for why. The image file is kept in case it's restored.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->update(['is_active' => false]);

        return redirect()->route('admin.products.index')->with('status', 'غذا از منو حذف شد.');
    }

    public function restore(Product $product): RedirectResponse
    {
        $product->update(['is_active' => true]);

        return redirect()->route('admin.products.index')->with('status', 'غذا بازگردانده شد.');
    }

    public function toggleAvailability(Product $product): RedirectResponse
    {
        $product->update(['is_available' => ! $product->is_available]);

        return back()->with('status', $product->is_available
            ? 'غذا به عنوان موجود علامت‌گذاری شد.'
            : 'غذا به عنوان ناموجود علامت‌گذاری شد.');
    }
}
