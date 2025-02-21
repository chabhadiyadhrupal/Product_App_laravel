<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'collection_product');
    }
}
