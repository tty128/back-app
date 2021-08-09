<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $table = 'postmeta';
    protected $primarykey = 'meta_id';

    public function post()
    {
        return $this->belongsTo('App\Post','post_id');
    }

}
