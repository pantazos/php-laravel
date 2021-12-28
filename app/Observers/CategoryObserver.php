<?php

namespace App\Observers;

use App\Http\Controllers\Traits\KeyGeneratingTrait;
use App\Models\Category;

class CategoryObserver
{
    use KeyGeneratingTrait;

    public function creating(Category $category)
    {
        $category->key = $category->key ?: $this->generateKey($category);
    }
}
