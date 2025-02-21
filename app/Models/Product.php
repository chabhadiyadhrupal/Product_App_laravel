<?php

namespace App\Models;
use App\Models\Variant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    
     use HasFactory;
    
        protected $fillable = ['title', 'hanle', 'image', 'description', 'price'];
    
        public function collections()
        {
            return $this->belongsToMany(Collection::class, 'collection_product');
        }
        public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    public  function addtocart()
    {
        return $this->hasMany(addtocart::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    }
    
    