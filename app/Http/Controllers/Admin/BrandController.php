<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $brands = Brand::orderBy('name')
            ->when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->paginate(15);

        return view('admin.brands.index', compact('brands', 'search'));
    }

    public function create()
    {
        return view('admin.brands.create_edit', ['brand' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:brands,slug',
        ]);

        Brand::create([
            'name'             => $request->name,
            'slug'             => $request->slug ?: Brand::generateUniqueSlug($request->name),
            'logo'             => $this->firstUploadId($request->logo),
            'banner'           => $this->firstUploadId($request->banner),
            'description'      => $request->description,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        flash('Thương hiệu đã được thêm thành công.')->success();
        return redirect()->route('admin.brands.index');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.create_edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:brands,slug,' . $brand->id,
        ]);

        $brand->update([
            'name'             => $request->name,
            'slug'             => $request->slug ?: Brand::generateUniqueSlug($request->name, $brand->id),
            'logo'             => $this->firstUploadId($request->logo) ?? $brand->logo,
            'banner'           => $this->firstUploadId($request->banner) ?? $brand->banner,
            'description'      => $request->description,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        flash('Thương hiệu đã được cập nhật.')->success();
        return redirect()->route('admin.brands.index');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        flash('Đã xoá thương hiệu.')->success();
        return redirect()->route('admin.brands.index');
    }

    private function firstUploadId(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }
        $parts = array_values(array_filter(array_map('trim', explode(',', $value))));
        return $parts[0] ?? null;
    }
}
