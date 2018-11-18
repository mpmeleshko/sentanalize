<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'product_id',
        'author',
        'review',
        'quality',
        'defect',
        'date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}