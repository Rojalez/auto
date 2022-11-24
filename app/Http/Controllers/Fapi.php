<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Swagger\Configuration;
use App\Swagger\Api\ManufacturerListApi;
use App\Swagger\Api\CatalogDtApi;
use App\Swagger\Model\ManufacturerListRow;
use GuzzleHttp\Client;

class Fapi
{

    protected $key = '0c344cc1-32be-4d2d-9b54-22e5dbb1f786';
    protected $domain = 'https://fapi.iisis.ru/fapi/v2';


    public function catalogsListGet () {

        $response = Http::get($this->domain.'/catalogList/dt/manufacturerList', [
            'ui' => $this->key
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function modelsListGet ($mfi) {

        $response = Http::get($this->domain.'/catalogList/dt/modelList', [
            'ui' => $this->key,
            'mfi' => $mfi
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function modifications ($mi) {

        $response = Http::get($this->domain.'/catalogList/dt/modificationList', [
            'ui' => $this->key,
            'mi' => $mi
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function tree ($mi) {

        $response = Http::get($this->domain.'/catalogList/dt/treeList', [
            'ui' => $this->key,
            'mi' => $mi
        ]);

        $answer = json_decode($response->getBody());

        $part_list = [];

        foreach ($answer as $ans) {
            $ans = (array) $ans;
            
            if ($ans['pi'] != 0) {
                $this->search_key($ans['pi'], $part_list, $ans);
            } else {
                $part_list[$ans['i']] = $ans;
            }
            
        }


        return $part_list;
    }

    public function search_key($searchKey, array &$arr, $ans)
    {
        // Если в массиве есть элемент с ключем $searchKey, то ложим в результат
        if (isset($arr[$searchKey])) {
            $arr[$searchKey]['pod'][$ans['i']] = $ans;
        }
        // Обходим все элементы массива в цикле
        foreach ($arr as $key => &$param) {
            // Если эллемент массива есть массив, то вызываем рекурсивно эту функцию
            if (is_array($param)) {
                $this->search_key($searchKey, $param, $ans);
            }
        }
    }

    public function partsGet ($i, $mi) {

        $response = Http::get($this->domain.'/catalogList/dt/productList', [
            'ui' => $this->key,
            'nodei' => $i,
            'modi' => $mi
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function brandsLists ($n) {

        $response = Http::get($this->domain.'/productList', [
            'ui' => $this->key,
            'n' => $n
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }








}