<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'commets';
    protected $fillabel = ['body', 'user_ids'];

    //* relacion 1:N (inversa)
    public function user(){
        return $this->belongsTo(User::class);
    }

    //* relacion N:N inversa
    public function posts(){
        return $this->belongsToMany(Post::class);
    }

}
