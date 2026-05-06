<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\Model;

#[ApiResource]
class Book extends Model
{
    protected $fillable = ['title', 'author', 'price','file_path', 'cover_image'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}


