<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['name','email',];

    //* relacion 1:1
    public function blog() {
        return $this->hasOne(Blog::class);
    }

    //* relacion 1:N
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
