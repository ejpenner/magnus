<?php

namespace Magnus\Http\Controllers;

use Magnus\Category;
use Illuminate\Http\Request;

use Magnus\Http\Requests;

class BrowseController extends Controller
{
    public function browse(Request $request, Category $category1, Category $category2 = null, Category $category3 = null, Category $category4 = null)
    {
        $categories = [$category1, $category2, $category3, $category4];

        $query = '';
    }
}
