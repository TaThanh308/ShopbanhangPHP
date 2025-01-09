<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hiển thị danh sách các danh mục
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả các danh mục
        return view('admin.categories.index', compact('categories'));
    }

    // Hiển thị form tạo mới danh mục
    public function create()
    {
        return view('admin.categories.create');
    }

    // Lưu danh mục mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được tạo thành công.');
    }

    // Hiển thị một danh mục cụ thể
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    // Hiển thị form chỉnh sửa danh mục
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật thông tin của danh mục
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    // Xóa danh mục
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được xóa thành công.');
    }
}
