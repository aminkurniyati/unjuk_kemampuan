<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $article = Article::latest();

        if (!empty($request->get('keyword'))) {

            // $article = $article->where('judul', 'like', '%'.$request->get('keyword').'%');
            $article = $article->where('judul', 'like', '%'.$request->get('keyword').'%')->orWhere('isi', 'like', '%'.$request->get('keyword').'%');

        }

        $article = $article->paginate(10);

        $rank = $article->firstItem();

        $title  = "PT WES MAKMUR";

        return view('admin.artikel.list', compact('rank','article', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title']  = "PT WES MAKMUR";
        return view('admin.artikel.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi'   => 'required'
       ]);

       if ($validator->fails()) {

            return redirect()->route('article.create')->withErrors($validator)->withInput();
        
        } else {

            $article = new Article();
            $article->judul  = $request->judul;
            $article->isi = $request->isi;
            $article->save();
            
            //redirect to index
            return redirect()->route('article.index')->with(['success' => 'Artikel Berhasil Disimpan!']);
        }

       
   }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //get category by ID
        $data = Article::find($id);
        // dd($category);
        if (empty($data)) {
            return redirect()->route('article.index')->with(['error' => 'Data tidak ditemukan']);
        }       
        $title  = "PT WES MAKMUR";
        //render view with post
        return view('admin.artikel.show', compact('data', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //get category by ID
        $data = Article::find($id);
        // dd($category);
        if (empty($data)) {
            return redirect()->route('article.index')->with(['error' => 'Data tidak ditemukan']);
        }       
        $title  = "PT WES MAKMUR";
        //render view with post
        return view('admin.artikel.edit', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Article::find($id);

        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi'   => 'required'
       ]);

       if ($validator->passes()) {
            $post->judul= $request->judul;
            $post->isi  = $request->isi;

            $post->update();

            return redirect()->route('article.index')->with(['success' => 'Data berhasil diupadate!']);

       } else {

            return redirect()->route('article.index')->with(['error' => 'Artikel gagal diupadate!']);
       }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data   = Article::find($id);

        if (empty($data)) {

            return redirect()->route('article.index')->with(['error' => 'Data tidak ditemukan']);
        }else {

            $data->delete($id);
            return redirect()->route('article.index')->with('success', 'Data berhasil dihapus!');
        }
    }
}
