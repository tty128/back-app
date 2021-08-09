<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $table = 'taxonomy';
    // protected $primaryKey = 'taxonomy_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function terms()
    {
        return $this->hasMany('App\Term');
    }

    // public function termRelationship()
    // {
    //     return $this->belongsToMany('App\Post');
    // }
}
