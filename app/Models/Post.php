<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = ['title','body','blog_id'];

    //* Relacion 1:N inversa
    public function blog() {
        return $this->belongsTo(Blog::class);
    }

    //* Relacion N:N 
    public function comments(){
        return $this->belongsToMany(Comment::class);
    }

}
