<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $imageName =  $this->saveImage($request, $category);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->description = $request->description;
        $category->image = $imageName;

        $category->save();

        Toastr::success('Created category!', 'Success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $imageName = '';

        if ($request->image != null) {
            $imageName = $this->saveImage($request, $category);
        } else {
            $imageName = $category->image;
        }


        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->description = $request->description;
        $category->image = $imageName;

        $category->save();

        Toastr::success('Updated category!', 'Success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        Storage::disk('public')->delete('category/' . $category->image);
        $category->delete();
        Toastr::success('Deleted category!', 'Success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category
     * @return string
     */
    public function saveImage(Request $request, Category $category)
    {
        //Image and save file
        $image = $request->image;
        $imageName = Str::slug($request->name, '-') . uniqid() . '.' . $image->getClientOriginalName();

        if (!Storage::disk('public')->exists('category')) {
            Storage::disk('public')->makeDirectory('category');
        }

        //delete file if exist
        if ($category->image != null) {
            if (Storage::disk('public')->exists('category/' . $category->image)) {
                Storage::disk('public')->delete('category/' . $category->image);
            }
        }

        $image->storeAs('category', $imageName, 'public');

        return $imageName;
    }
}
