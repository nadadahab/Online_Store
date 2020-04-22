<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'details','image'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function can_be_deleted()
    {
        $products = $this->products;
        if($products){
            return false;
        }else{
            return true;
        }
    }

}
