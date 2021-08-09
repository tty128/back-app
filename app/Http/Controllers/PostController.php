<?php

namespace App\Http\Controllers;

use App\Post;
use App\Term;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Post $post)
    {
        $auth_id = isset($request->user()->id) ? $request->user()->id : Auth::id();
        $post = $post
            ->where('author', '=', $auth_id)
            ->orWhere('post.status', '<>', 'private')
            ->orderBy('post.id', 'desc')
            ->join('users as pca', 'author', '=', 'pca.id')
            ->leftJoin('users as pua', 'update_author', '=', 'pua.id')
            ->get([
                'post.id',
                'post.created_at',
                'post.updated_at',
                'post.status',
                'title',
                'pca.name as author_name',
                'pua.name as update_author_name',
            ]);

        return ['post' => $post];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Post $post)
    {
        $post->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,User $user, Post $post)
    {

        $collection = collect($post);

        $terms = $post->terms()
            ->join('taxonomy as tx', 'taxonomy_id', '=', 'tx.id')
            ->get([
                'term.id',
                'term.name',
                'tx.name as taxonomy_name'
            ])
            ->groupBy('taxonomy_name')
            ->reject(function ($value, $key) {
                return $key == 'category';
            });

        $collection->put('taxonomy', $terms);

        $merge = ['author' => $user->find($post->author)->name];
        if(isset($post->update_author)){
            $merge['update_author'] = $user->find($post->update_author)->name;
        }

        $collection = $collection->merge($merge);

        switch ($post->status) {
            case 'public':
                return $collection;

            case 'private':
                return $request->user()->id == $post->author ? $collection : redirect()->route('login');

            case 'member':
                return isset($request->user()->id) ? $collection : redirect()->route('login');

            default:
                return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($limit, $id)
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
    public function update(Request $request,Post $post)
    {
        if($this->runCheck($request, $post)){
            $post->update($request->all());
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        if ($this->runCheck($request, $post)) {
            $post->delete();
        };
    }

    public function runCheck(Request $request, Post $post)
    {
        if (isset($post, $request)) {
            $creater = $post->author === $request->user()->id ? true : false;
            $status = $post->status !== 'private' ? true : false;
            if ($status || $creater) {
                return true;
            }
        }
        return false;
    }
}
