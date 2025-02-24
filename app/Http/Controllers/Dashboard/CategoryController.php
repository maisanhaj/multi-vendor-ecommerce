<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $categories = Category::all(); // return ob of Collection
        $categories = Category::with('parent')->paginate(5);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();

        return view('dashboard.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image'); // return uploaded object
            // take the file from the temporary place to permenant place
            // can you write this  $file->store('uploade', 'public')
            $path = $file->store('uploade', [
                'disk' => 'public',
            ]

            );
            $data['image'] = $path;

        }
        // $request->merge(['slug'=>Str::slug($request->post(name))])
        $category = Category::create($data);

        // PRG post redirect gat
        return redirect()->route('categories.index')->with('success', 'Category Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        // so this for not display self in the options of parent categories
        // select * from category where id <> $id and (parent_id ISNULL or parent_id <> $id)
        $parents = Category::where('id', '<>', $id)
            ->whereNull('parent_id')
            ->orWhere('parent_id', '<>', $id)
            ->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $old_image = $category->image;
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image'); // return uploaded object
            $path = $file->store('uploade', [
                'disk' => 'public',
            ]
            );
            $data['image'] = $path;

        }
        if ($old_image && isset($data['image'])) {
            Storage::disk('public')->delete($old_image);
        }
        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        // make a comment because use soft delete
        // if($category->image){
        //     Storage::disk('public')->delete($category->image);
        // }

        // the destroy method excute this query (Category::where('id','=',$id)->delete)
        // Category::destroy($id);

        return redirect()->route('categories.index')->with('success', 'Category Deleted');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->get();

        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category Restored');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category Deleted forever');
    }
}
