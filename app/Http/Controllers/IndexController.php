<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Fapi; //Класс для получения данных из апи дляя каталога
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class IndexController extends Controller
{
    //Возвращает главную страницу
    public function index () {

        $users = User::where('id', '!=', Auth::user()->id)->get();
        return Inertia::render('Frontend/Index', ['users' => $users]);

    }

    public function catalog () {

        $fapi = new Fapi;
        $response = $fapi->catalogsListGet();

        return Inertia::render('Frontend/Catalog', ['catalogs' => $response]);

    }

    public function catalogs ($catalog_code, Request $request) {
        $fapi = new Fapi;
        $response = $fapi->modelsListGet($catalog_code);

        return Inertia::render('Frontend/Catalogs', ['models' => $response, 'marka' => $request->marka]);

    }

    public function modifications ($catalog_code, Request $request) {
        $fapi = new Fapi;
        $response = $fapi->modifications($catalog_code);
        
        return Inertia::render('Frontend/Mods', ['modifications' => $response]);

    }

    public function tree ($catalog_code, Request $request) {
        $fapi = new Fapi;
        $response = $fapi->tree($catalog_code);
        return Inertia::render('Frontend/Tree', ['tree' => $response]);

    }

    public function partgroups ($ssd, $link, Request $request) {
        $levam = new Levam;
        $group = -1;
        if ($request->group != null) {
            $group = $request->group;
        }
        $response = $levam->partGroupsGet($ssd, $link, $group);

        return Inertia::render('Frontend/Partgroups', ['partgroups' => $response]);

    }

    public function partsget ($i, $mi, Request $request) {
        $fapi = new Fapi;
        $response = $fapi->partsGet($i, $mi);

        return Inertia::render('Frontend/Part-list', ['parts' => $response]);

    }

    public function changeUser (Request $request) {
        
        if ($request->session()->has('user_id')){
            $request->session()->forget('user_id');
            $request->session()->forget('basket');
        }
        if ($request->user_id != null) {
            $request->session()->put('user_id', $request->user_id);
        }
        
        return redirect()->back();
    }

}
