<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
use App\Taxonomy;
use App\Term;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Taxonomy $taxonomy)
    {
        return $taxonomy->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Taxonomy::create(['name' => $request->query('name')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Taxonomy $taxonomy)
    {
        return $taxonomy;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taxonomy $taxonomy)
    {
        $taxonomy->update($request->query('name'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Taxonomy::destroy($id);
    }
}
