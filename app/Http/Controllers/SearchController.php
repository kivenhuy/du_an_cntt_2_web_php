<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //

    public function ajax_search(Request $request)
    {
        $keywords = array();
        $query = $request->search;
        // dd($query);
        $products = Products::where('published', 1)->where('tags', 'like', '%' . $query . '%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',', $product->tags) as $key => $tag) {
                if (stripos($tag, $query) !== false) {
                    if (sizeof($keywords) > 5) {
                        break;
                    } else {
                        if (!in_array(strtolower($tag), $keywords)) {
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        // $products_query = filter_products(Products::query());

        $products_query = Products::query()->where('published', 1)
            ->where(function ($q) use ($query) {
                foreach (explode(' ', trim($query)) as $word) {
                    $q->where('name', 'like', '%' . $word . '%')
                        ->orWhere('tags', 'like', '%' . $word . '%');
                        // ->orWhereHas('product_translations', function ($q) use ($word) {
                        //     $q->where('name', 'like', '%' . $word . '%');
                        // })
                        // ->orWhereHas('stocks', function ($q) use ($word) {
                        //     $q->where('sku', 'like', '%' . $word . '%');
                        // });
                }
            });
        $case1 = $query . '%';
        $case2 = '%' . $query . '%';

        $products_query->orderByRaw("CASE 
                WHEN name LIKE '$case1' THEN 1 
                WHEN name LIKE '$case2' THEN 2 
                ELSE 3 
                END");
        $products = $products_query->limit(3)->get();

        $categories = [];

        $shops = [];

        if (sizeof($keywords) > 0 || sizeof($categories) > 0 || sizeof($products) > 0 || sizeof($shops) > 0) {
            return view('user_layout.partials.search_content', compact('products', 'categories', 'keywords', 'shops'));
        }
        return '0';
    }
}
