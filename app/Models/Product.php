<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;



class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'images',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
