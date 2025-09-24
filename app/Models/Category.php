<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id', 'description', 'sort_order'];

    // 獲取子分類
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order', 'asc');
    }

    // 獲取父分類
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 獲取祖先層級數量
    public function getAncestorsCountAttribute()
    {
        $count = 0;
        $parent = $this->parent;
        
        while (!is_null($parent)) {
            $count++;
            $parent = $parent->parent;
        }
        
        return $count;
    }

    // 判斷是否為指定分類的祖先
    public function isAncestorOf($category)
    {
        $parent = $category->parent;
        while (!is_null($parent)) {
            if ($parent->id === $this->id) {
                return true;
            }
            $parent = $parent->parent;
        }
        return false;
    }

    // 判斷是否為指定分類的子孫
    public function isDescendantOf($category)
    {
        $parent = $this->parent;
        while (!is_null($parent)) {
            if ($parent->id === $category->id) {
                return true;
            }
            $parent = $parent->parent;
        }
        return false;
    }

    // 與商品的關係
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
