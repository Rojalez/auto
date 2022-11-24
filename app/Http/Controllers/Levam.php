<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class Levam 
{

    public $key = 'd13a3dfe7d867f281717a33ee268014e';
    public $domain = 'https://api.levam.ru/oem/v1/';
    

    public function catalogsListGet ($type) {
        $response = Http::get($this->domain.'/CatalogsListGet', [
            'api_key' => $this->key,
            'type' => $type,
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function modelsListGet2 ($catalog_code) {
        $response = Http::get($this->domain.'/ModelsListGet2', [
            'api_key' => $this->key,
            'catalog_code' => $catalog_code,
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function vehicleParamsSet ($catalog_code, $family, $model) {
        $response = Http::get($this->domain.'/VehicleParamsSet', [
            'api_key' => $this->key,
            'catalog_code' => $catalog_code,
            'family' => $family,
            'model' => $model
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function vehicleModificationsGet ($ssd) {
        $response = Http::get($this->domain.'/VehicleModificationsGet', [
            'api_key' => $this->key,
            'ssd' => $ssd,
            'lang' => 'ru'
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function partGroupsGet ($ssd, $link, $group) {
        if ($group == -1) {
            $response = Http::get($this->domain.'/PartGroupsGet', [
                'api_key' => $this->key,
                'ssd' => $ssd,
                'link' => $link,
                'lang' => 'ru',
            ]);
        } else  {
            $response = Http::get($this->domain.'/PartGroupsGet', [
                'api_key' => $this->key,
                'ssd' => $ssd,
                'link' => $link,
                'lang' => 'ru',
                'group' => $group,
            ]);
        }


        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function partsGet ($ssd, $link, $group) {
        $response = Http::get($this->domain.'/PartsGet', [
            'api_key' => $this->key,
            'ssd' => $ssd,
            'lang' => 'ru',
            'link' => $link,
            'group' => $group
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function vinFind ($vin) {
        $response = Http::get($this->domain.'/VinFind', [
            'api_key' => $this->key,
            'vin' => $vin,
            'lang' => 'ru',
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function treeGet ($link) {
        $response = Http::get($this->domain.'/TreeGet', [
            'api_key' => $this->key,
            'link' => $link,
            'lang' => 'ru',
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function treeNodeSearch ($link, $ssd, $path) {
        $response = Http::get($this->domain.'/TreeNodeSearch', [
            'api_key' => $this->key,
            'link' => $link,
            'ssd' => $ssd,
            'path' => $path,
            'lang' => 'ru',
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function treeNodePartsGet ($link, $ssd, $path, $group) {
        $response = Http::get($this->domain.'/TreeNodePartsGet', [
            'api_key' => $this->key,
            'link' => $link,
            'ssd' => $ssd,
            'path' => $path,
            'group' => $group,
            'lang' => 'ru',
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }

    public function replacementsGet ($code, $brand) {
        $response = Http::get('https://am-api.levam.ru/v1/ReplacementsGet', [
            'api_key' => $this->key,
            'part_nimber' => $code,
            'brand' => $brand,
            'lang' => 'ru',
        ]);

        $answer = json_decode($response->getBody());

        return $answer;
    }


}