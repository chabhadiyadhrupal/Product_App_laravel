<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class addtocart extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
