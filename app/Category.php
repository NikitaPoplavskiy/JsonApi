<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id', 'name', 'parent_category', 'external_id'];
    
    public function products()
    {
        return $this->belongsToMany('App/Product');
    }
}
