<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'code','image' ,'category_id','featured'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
