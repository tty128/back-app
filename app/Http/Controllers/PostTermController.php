<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostTerm;
use Illuminate\Http\Request;

class PostTermController extends Controller
{
    public function __invoke (Request $request, PostTerm $postTerm) {
        if($request->post_id != -1){
            $post_id = $request->post_id;
            $postTerm->where('post_id', '=', $post_id)->delete();
        } else {
            $post_id = Post::all()->last()->id;
        }

        $term_str = $request->term_id;
        if(!empty($term_str)){
            $terms = explode(',', $term_str);
            foreach ($terms as $term) {
                $postTerm->create(
                    [
                        'post_id' => $post_id,
                        'term_id' => $term
                    ]);
            }
        }
    }
}
