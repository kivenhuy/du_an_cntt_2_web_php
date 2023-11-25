<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = \App\Models\Uploads::find($id)) != null) {
            return $asset->external_link == null ? my_asset($asset->file_name) : $asset->external_link;
        }
        return static_asset('assets/img/placeholder.jpg');
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Illuminate\Support\Facades\Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset($path, $secure);
        }
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}

if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}



function translate($key, $lang = null, $addslashes = false)
{
    return $key; 
}


if (!function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'fa fa-star active'></i>";
        $halfStar = "<i class = 'fa fa-star half'></i>";
        $emptyStar = "<i class = 'fa fa-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        echo $html;
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = '//' . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root;
    }
}

if (!function_exists('filter_products')) {
    function filter_products($products)
    {

        $products = $products->where('published', '1')->where('auction_product', 0)->where('approved', '1');
        // $verified_sellers = verified_sellers_id();
        // if (get_setting('vendor_system_activation') == 1) {
        //     return $products->where(function ($p) use ($verified_sellers) {
        //         $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
        //             $q->whereIn('user_id', $verified_sellers);
        //         });
        //     });
        // } else {
        //     return $products->where('added_by', 'admin');
        // }
    }
}