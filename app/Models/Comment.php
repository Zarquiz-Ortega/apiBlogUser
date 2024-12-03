<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = ['body', 'user_id', 'post_id'];

    //* relacion 1:N (inversa)
    public function user(){
        return $this->belongsTo(User::class);
    }

    //* relacion 1:N inversa
    public function post(){
        return $this->belongsTo(Post::class);
    }

}
