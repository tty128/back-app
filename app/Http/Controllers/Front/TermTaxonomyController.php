<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Post;
use App\Taxonomy;
use App\Term;
use Illuminate\Http\Request;

class TermTaxonomyController extends Controller
{
    public function index(Term $term)
    {
        return $term
            ->join('taxonomy as tx', 'taxonomy_id', '=', 'tx.id')
            ->get([
                'term.id',
                'term.name',
                'tx.name as taxonomy_name'
            ])
            ->groupBy('taxonomy_name');
    }

    public function show(Post $post, Term $term, Taxonomy $taxonomy, $taxonomy_name, $term_name)
    {
        $post_column = [
            'post.id',
            'post.title',
            'post.category',
            'post.eyecatch'
        ];

        if ($taxonomy_name == 'category') {
            return $post
                ->where('status', '=', 'public')
                ->where('category','=', $term_name)
                ->orderBy('created_at', 'desc')
                ->get($post_column);
        } else {
            return $term
                ->where('taxonomy_id','=', $taxonomy->where('name','=', $taxonomy_name)->value('id'))
                ->where('name','=', $term_name)
                ->first()
                ->posts()
                ->where('status', '=', 'public')
                ->orderBy('created_at','desc')
                ->get($post_column);
        }
    }
}
