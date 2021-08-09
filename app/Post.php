<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'post';
    // protected $primaryKey = 'post_id';
    protected $hidden = array('pivot');

    protected $fillable = [
        'author',
        'status',
        'title',
        'body',
        'category',
        'eyecatch'
    ];

    public function terms() {
        return $this->belongsToMany('App\Term');
    }

    // public function getAuthorAttribute($value)
    // {
    //     return User::find($value)->name;
    // }

    // public function getUpdateAuthorAttribute($value)
    // {
    //     return isset($value) ? User::find($value)->name : null;
    // }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($q) {
            if(Auth::check()){
                $user_id = Auth::id();
                $q->author = $user_id;
            }
        });
        self::updating(function ($q) {
            if (Auth::check()) {
                $user_id = Auth::id();
                $q->update_author = $user_id;
            }
        });
    }
}
