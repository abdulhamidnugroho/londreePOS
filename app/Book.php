<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description'
    ];
    
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
