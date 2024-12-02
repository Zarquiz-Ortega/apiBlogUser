<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = ['name','url','user_id'];

    //* relacion 1:1 (inversa)
    public function user(){
        return $this->belongsTo(User::class);
    }

    //* Relacion 1:N 
    public function posts(){
        return $this->hasMany(Blog::class);
    }

}
