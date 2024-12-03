<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['title','body','post_id'];

    //* Relacion 1:N inversa
    public function blog() {
        return $this->belongsTo(Blog::class);
    }

    //* Relacion 1:N 
    public function comments(){
        return $this->hasMany(Comment::class);
    }

}
