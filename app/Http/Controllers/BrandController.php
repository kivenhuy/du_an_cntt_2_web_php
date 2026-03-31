<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Products;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Trang danh sách tất cả thương hiệu, nhóm theo chữ cái đầu tên (A-Z, 0-9).
     */
    public function index()
    {
        $brands = Brand::orderBy('name')->get();

        // Group by first character (0-9 → key "#", letters → key uppercase letter)
        $grouped = $brands->groupBy(function ($brand) {
            $first = mb_strtoupper(mb_substr($brand->name, 0, 1));
            return ctype_alpha($first) ? $first : '0-9';
        })->sortKeys();

        // Build alphabet nav: 0-9 + A..Z
        $alphabet = collect(array_merge(['0-9'], range('A', 'Z')));

        return view('user_layout.brands.index', compact('grouped', 'alphabet'));
    }

    /**
     * Trang chi tiết thương hiệu: banner + logo + mô tả + danh sách sản phẩm.
     */
    public function show(Request $request, string $slug)
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();

        $perPage = in_array((int) $request->per_page, [16, 32, 50]) ? (int) $request->per_page : 16;
        $sort_by = $request->sort_by ?? 'newest';
        $selected_categories = array_values(array_unique(array_filter(
            array_map('intval', (array) $request->input('selected_categories', [])),
            fn ($id) => $id > 0
        )));

        // Danh mục có sản phẩm thuộc thương hiệu (đăng bán).
        $filter_categories = \App\Models\Category::whereHas('products', function ($q) use ($brand) {
            $q->where('brand_id', $brand->id)->where('approved', 1)->where('published', 1);
        })->orderBy('name')->get();

        $query = Products::where('brand_id', $brand->id)->where('approved', 1)->where('published', 1);

        if (!empty($selected_categories)) {
            $query->whereIn('category_id', $selected_categories);
        }

        match ($sort_by) {
            'price-asc'  => $query->orderBy('unit_price', 'asc'),
            'price-desc' => $query->orderBy('unit_price', 'desc'),
            'oldest'     => $query->oldest(),
            default      => $query->latest(),
        };

        $products = $query->paginate($perPage)->withQueryString();

        return view('user_layout.brands.show', compact(
            'brand', 'products', 'sort_by', 'perPage',
            'filter_categories', 'selected_categories'
        ));
    }
}
