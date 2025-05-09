<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /** @use HasFactory<\Database\Factories\PhotoFactory> */
    use HasFactory;

    protected $fillable = [
      'product_id',
      'path',
      'alternate_text',
    ];

    public function product(){
        return $this->belongsTo(\App\Models\Product::class);
    }


}
