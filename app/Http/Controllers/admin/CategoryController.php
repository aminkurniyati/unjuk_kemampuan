<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::latest();

        if (!empty($request->get('keyword'))) {

            $categories = $categories->where('category_name', 'like', '%'.$request->get('keyword').'%');

        }

        $categories = $categories->paginate(10);

        $rank = $categories->firstItem();

        $title  = "PT WES MAKMUR";

        return view('admin.category.list', compact('rank','categories', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = "PT WES MAKMUR";
        return view('admin.category.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'      => 'required',
            'deskripsi' => 'required'
        ]);

        //create post
        Category::create([
            'category_name' => $request->nama,
            'category_desc' => $request->deskripsi
        ]);

        return redirect()->route('category.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        //get category by ID
        $data = Category::find($id);
        // dd($category);
        if (empty($data)) {
            return redirect()->route('category.index');
        }       
        $title  = "PT WES MAKMUR";
        //render view with post
        return view('admin.category.edit', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Category::find($id);

        $this->validate($request, [
            'nama'      => 'required',
            'deskripsi' => 'required'
        ]);

        $post->update([
            'category_name' => $request->nama,
            'category_desc' => $request->deskripsi
        ]);
        // $request->session()->flash('success', 'Category deleted successfully.');
        return redirect()->route('category.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::find($id)->delete($id);
        return redirect()->route('category.index')->with('success', 'Data berhasil dihapus!');
    }
}
