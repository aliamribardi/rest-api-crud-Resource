<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostControllser extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::latest()->paginate(5);
        
        return new PostResource(true, 'List Data Post', $data);

        // if($data){
        //     return new PostResource(true, 'List Data Post', $data);
        // } else {
        //     return new PostResource(false, 'failed');
        // }
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
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        // if ($validateData->fails()) {
        //     return response()->json($validateData->errors(), 422);
        // }

        $validateData['image'] = $request->file('image')->store('Post-Image');

        $data = Post::create($validateData);

        return new PostResource(true, 'Data Berhasil di tambah', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Post::where('id', $id)->first();

        return new PostResource(true, 'Data ditemukan', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        // if ($validateData->fails()) {
        //     return response()->json($validateData->errors(), 422);
        // }
        
        if($request->file('image')){
            if($request->oldImage){
                storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('Post-Image');
        }

        $data = Post::where('id', $id)->update($validateData);

        return new PostResource(true, 'Data Berhasil di update', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        // if($id){
            Storage::delete($id);
        // }
        // dd('data berhasil');

        // Post::destroy($post->id);
        $posts = Post::findOrfail($id);
        
        // // dd($data);
        
        $data = $posts->delete();

        return new PostResource(true, 'Data Berhasil di Hapus', null);
    }
}
