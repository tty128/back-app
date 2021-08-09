<?php

namespace App\Http\Controllers\Front;

use App\Post;
use App\Http\Controllers\Controller;
use App\Term;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $posts = $post
            ->where('status', '=', 'public')
            ->orderBy('id', 'desc')
            ->get([
                'id',
                'title',
                'category',
                'eyecatch'
            ]);

        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user,Post $post)
    {
        if ($post->status == 'public') {
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
            if (isset($post->update_author)) {
                $merge['update_author'] = $user->find($post->update_author)->name;
            }

            $collection = $collection->merge($merge);

            return $collection;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
