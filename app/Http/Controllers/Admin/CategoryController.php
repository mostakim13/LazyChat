<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getSubCat($cat_id)
    {
        $subcat = Subcategory::where('category_id', $cat_id)->orderBy('title', 'ASC')->get();
        return json_encode($subcat);
    }
}