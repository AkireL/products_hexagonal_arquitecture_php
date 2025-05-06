<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'stock',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Database\Factories\ProductFactory
     */
    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
