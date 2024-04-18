<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Termwind\Components\Dd;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produk = Product::latest();

        if (!empty($request->get('keyword'))) {

            $produk = $produk->where('nama', 'like', '%'.$request->get('keyword').'%');

        }

        $produk = $produk->paginate(10);

        $rank = $produk->firstItem();

        $title  = "PT WES MAKMUR";

        return view('admin.produk.list', compact('rank','produk','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = "PT WES MAKMUR";
        return view('admin.produk.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'  => 'required',
            'harga' => 'required',
            'deskripsi' => 'required'
       ]);

       if ($validator->fails()) {

        return redirect()->route('product.create')->withErrors($validator)->withInput();
    
        } else {

            $product = new Product();
            $product->nama  = $request->nama;
            $product->harga = $request->harga;
            $product->deskripsi = $request->deskripsi;
                // save image here
                if (!empty($request->image)) {
                    $imageName = time().'.'.$request->image->extension();
                    $request->image->move(public_path('uploads/product'), $imageName);
                    
                }else {
                    return redirect()->route('product.index')->with(['error' => 'Data Gagal Disimpan!']);
                }
            $product->foto = $imageName;
            $product->save();

            return redirect()->route('product.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }

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
        $data = Product::find($id);

        $title  = "PT WES MAKMUR";

        if (empty($data)) {

            return redirect()->route('product.index')->with(['error' => 'Produk tidak ditemukan!']);
        }
         
        //render view with post
        return view('admin.produk.edit', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {       
        $product = Product::find($id); 

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'  => 'required',
            'harga' => 'required',
            'deskripsi' => 'required'
       ]);

    //    if ($validator->fails()) {

    //     return redirect()->back()->withErrors($validator)->withInput();
    
    //     }

        $oldImage = $product->foto;

       if ($validator->passes()) {
            // save image here
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/product'), $imageName);
            File::delete(public_path().'/uploads/product/'.$oldImage);

            $product->nama  = $request->nama;
            $product->foto  = $imageName;
            $product->harga = $request->harga;
            $product->deskripsi = $request->deskripsi;
            $product->update();
            // Delete old images $oldImage
            File::delete(public_path().'/uploads/product/'.$oldImage);                

            return redirect()->route('product.index')->with(['success' => 'Data berhasil diupadate!']);

        } else {

            $product->nama  = $request->nama;
            $product->harga = $request->harga;
            $product->deskripsi = $request->deskripsi;
            $product->update();

            return redirect()->route('product.index')->with(['success' => 'Data berhasil diupadate!']);
        }    
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        File::delete(public_path().'/uploads/product/'.$product->foto);

        $product->delete($id);

        return redirect()->route('product.index')->with('success', 'Data berhasil dihapus!');
    }
}
