<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'price','file_path', 'cover_image'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}


