<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);

        return view('management.products.index', compact('products'));
    }

    public function create()
    {
        return view('management.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:plugin,theme,template,service,digital'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'is_subscription' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_subscription'] = $request->boolean('is_subscription');
        $validated['is_active'] = $request->boolean('is_active');

        Product::create($validated);

        return redirect()
            ->route('management.products.index')
            ->with('success', 'تمت إضافة المنتج بنجاح.');
    }

    public function edit(Product $product)
    {
        return view('management.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:plugin,theme,template,service,digital'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'is_subscription' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_subscription'] = $request->boolean('is_subscription');
        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        return redirect()
            ->route('management.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('management.products.index')
            ->with('success', 'تم حذف المنتج بنجاح.');
    }

    public function toggle(Product $product)
    {
        $product->update([
            'is_active' => !$product->is_active,
        ]);

        return redirect()
            ->route('management.products.index')
            ->with('success', 'تم تحديث حالة المنتج.');
    }
}