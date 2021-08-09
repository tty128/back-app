<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTerm extends Model
{
    protected $table = 'post_term';
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'term_id',
    ];
}
