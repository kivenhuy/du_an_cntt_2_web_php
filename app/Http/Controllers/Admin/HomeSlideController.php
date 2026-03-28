<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlide;
use Illuminate\Http\Request;

class HomeSlideController extends Controller
{
    public function index()
    {
        $slides = HomeSlide::orderBy('sort_order')->orderBy('id', 'desc')->get();

        return view('admin.home_slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.home_slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|string',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $photoId = $this->firstUploadId($request->photo);
        if (! $photoId) {
            flash('Vui lòng chọn ảnh')->error();

            return back()->withInput();
        }

        HomeSlide::create([
            'photo' => (int) $photoId,
            'link' => $request->link ?: null,
            'sort_order' => (int) ($request->sort_order ?? 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        flash('Slide trang chủ đã được tạo thành công')->success();

        return redirect()->route('admin.home_slides.index');
    }

    public function destroy(HomeSlide $home_slide)
    {
        $home_slide->delete();
        flash('Slide trang chủ đã được xóa thành công')->success();

        return redirect()->route('admin.home_slides.index');
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
