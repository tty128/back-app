<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'term';
    // protected $primaryKey = 'term_id';
    public $timestamps = false;
    protected $hidden = array('pivot');

    protected $fillable = [
        'name',
        'taxonomy_id',
    ];

    public function posts() {
        return $this->belongsToMany('App\Post');
    }

    public function taxonomy()
    {
        return $this->belongsTo('App\Taxonomy');
    }
}
