<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\Storage;
use App\Helpers\StorageHelper;




class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage-categories'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        $categories = Category::query()
            ->select(['id', 'slug', 'image', 'created_at'])
            ->with(['translations'])
            ->withCount('products')
            ->latest()
            ->paginate(15);

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->safe()->except('image');

        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($request->input('en.name') ?? $request->input('ar.name') ?? 'category-' . time());
        } else {
            $data['slug'] = \Illuminate\Support\Str::slug($data['slug']);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/uploads/category', 'public');
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', __('Category created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)

    {

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->safe()->except('image');

        if (!empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['slug']);
        }

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('assets/uploads/category', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', __('Category updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

       $category->translations()->delete();
        Storage::delete($category->image);

        $category->delete();
        return redirect()->route('categories.index')->with('success', __('Category deleted successfully!'));
    }
}
