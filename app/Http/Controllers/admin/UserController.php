<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title  = "PT WIS MAKMUR";
        $users  = User::latest();
        if (!empty($request->get('keyword'))) {

            $userss = $users->where('name', 'like', '%'.$request->get('keyword').'%');

        }

        $users  = $users->paginate(10);
        $rank   = $users->firstItem();
        return view('admin.user.list', compact('rank','users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title']  = "PT WES MAKMUR";
        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required',

       ]);

       if ($validator->fails()) {

        return redirect()->route('user.create')->withErrors($validator)->withInput();
        
        } else {

            User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->pasword),
            ]);
            
            //redirect to index
            return redirect()->route('user.index')->with(['success' => 'Artikel Berhasil Disimpan!']);
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
    public function edit(string $id)
    {
        //get category by ID
        $data = User::find($id);

            if (empty($data)) {
                return redirect()->route('article.index')->with(['error' => 'Data tidak ditemukan']);
            }    

            $title  = "PT WES MAKMUR";
            $users = User::orderBy('name', 'ASC')->get();
            //render view with post
            return view('admin.user.edit', compact('data', 'users', 'title'));
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //{{ ($data->role == 1) ? 'selected' : ''}}

        // 'email' => 'unique:users,email,'.$post->id,

        $post = User::find($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'email',
                'password' => 'required|confirmed|min:6',
                'role' => 'required',
    
           ]);
    
           if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
            
            } else {
    
                $post->name     = $request->name;
                $post->email    = $request->email;
                $post->role     = $request->role;
                $post->password = Hash::make($request->pasword);

                $post->update();
                
                //redirect to index
            }
            
            return redirect()->route('user.index')->with(['success' => 'User Berhasil Diedit!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data   = User::find($id);

        if (empty($data)) {

            return redirect()->route('user.index')->with(['error' => 'Data tidak ditemukan']);
        }else {

            $data->delete($id);
            return redirect()->route('user.index')->with('success', 'Data berhasil dihapus!');
        }
    }
}
