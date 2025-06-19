<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_category_id', 'title', 'slug', 'url', 'parent_id', 'order', 'status'];

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    // public function children()
    // {
    //     return $this->hasMany(Menu::class, 'parent_id');
    // }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->where('status', 1)->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
