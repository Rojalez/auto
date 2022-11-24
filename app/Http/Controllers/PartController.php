<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Api;
use App\Http\Controllers\ForumAuto;

class PartController extends Controller
{
    //Список брендов при поиске по артикулу
    public function brands_list ($part_code) {
        if (stripos($part_code, '@')) {
            
            $str_array = explode('@', $part_code);

            return redirect('/parts/brands-list/'.$str_array[0].'/brand?brand='.$str_array[1]);
        }

        $api = new Api;
        $brands_list = $api->get_brands_list($part_code);
        
        return Inertia::render('Frontend/Brands', ['brands' => $brands_list, 'code' => $part_code]);

    }

    //Список товаров при поиске по артикулу. Возвращает список товаров.
    public function parts_list ($part_code, Request $request) {
        $api = new Api;
        $parts_list = $api->get_parts_list($part_code, $request->brand);

        return Inertia::render('Frontend/Parts', ['parts' => $parts_list]);

    }


}