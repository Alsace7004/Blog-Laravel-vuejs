<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable=['user_id','title','description','photo'];

    public function user()
    {
        //return $this->belongsTo(User::class,'user_id');
        return $this->belongsTo('App\User');
    }
}
