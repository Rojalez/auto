<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Partcombrand;

class Armtek
{

    protected $login = '89373000900@mail.ru';
    protected $psw = '2020bostonsto2';
    protected $vkorg = 4000;
    protected $kunnr_rg = 43272593;
    protected $kunnr_za = 48153889;
    protected $kunwe = 43272593;


    public function getUserVkorgList () {
        $login = base64_encode($this->login.':'.$this->psw);
        $response = Http::withHeaders([
                    'Authorization'=>'Basic '.$login,
                    'Content-type'=>'application/json'
                ])->get('http://ws.armtek.ru/api/ws_user/getUserVkorgList');
        dd(json_decode($response->getBody()));
    }

    public function getUserInfo () {
        $login = base64_encode($this->login.':'.$this->psw);
        $response = Http::withHeaders([
                    'Authorization'=>'Basic '.$login,
                    'Content-type'=>'application/json'
                ])->post('http://ws.armtek.ru/api/ws_user/getUserInfo', [
                    'VKORG'=>$this->vkorg,
                    'STRUCTURE'=>1
                ]);
        dd(json_decode($response->getBody()));
    }

    public function get_brands_list ($code) {
        $login = base64_encode($this->login.':'.$this->psw);
        $response = Http::withHeaders([
                    'Authorization'=>'Basic '.$login,
                    'Content-type'=>'application/json'
                ])->post('http://ws.armtek.ru/api/ws_search/assortment_search', [
                    'VKORG'=>$this->vkorg,
                    'PIN'=>$code
                ]);
        $answer = json_decode($response->getBody());
        
        if (is_array($answer->RESP)) {
            return $answer->RESP;
        }
        

        return [];
        
    }

    public function get_parts_list ($code, $brand) {
        $login = base64_encode($this->login.':'.$this->psw);
        $response = Http::withHeaders([
                    'Authorization'=>'Basic '.$login,
                    'Content-type'=>'application/json'
                ])->post('http://ws.armtek.ru/api/ws_search/search', [
                    'VKORG'=>$this->vkorg,
                    'KUNNR_RG'=>$this->kunnr_rg,
                    'BRAND'=>$brand,
                    'PIN'=>$code,
                    'QUERY_TYPE'=>2,
                    'KUNNR_ZA'=>$this->kunnr_za
                ]);

        $answer = json_decode($response->getBody());
        
        if (is_array($answer->RESP)) {
            return $answer->RESP;
        }

        return [];

        
    }

    public function getCheckout ($data) {
        $login = base64_encode($this->login.':'.$this->psw);
        $item = array(                    
        //'KEYZAK'=>$data['info'][0]['KEYZAK'],
        'BRAND'=>$data['info'][0]['brand'],
        'PIN'=>$data['info'][0]['code'],
        'KWMENG'=>$data['mount'][0]
    );
        $response = Http::withHeaders([
                    'Authorization'=>'Basic '.$login,
                    'Content-type'=>'application/json'
                ])->post('http://ws.armtek.ru/api/ws_order/createOrder', [
                    'VKORG'=>$this->vkorg,
                    'KUNRG'=>$this->kunnr_rg,
                    'KUNZA'=>$this->kunnr_za,
                    'INCOTERMS'=>0,
                    'ITEMS'=>array($item)
                ]);

        $answer = json_decode($response->getBody());
        
        if (is_array($answer->RESP)) {
            return $answer->RESP;
        }

        return [];
    }

    // public function getOrders () {
    //     $list = [];
    //     $login = base64_encode($this->login.':'.$this->psw);
    //     $response = Http::withHeaders([
    //         'Authorization'=>'Basic ['.$login.']',
    //         'Accept'=>'application/json',
    //         'Content-type'=>'application/json'
    //     ])->get('https://www.part-kom.ru/engine/api/v1/motion');
    //     $answer = json_decode($response->getBody());
    //     if (is_array($answer)) {
    //         foreach ($answer as $ans) {
    //             $key = $ans->comment;
    //             $list[$key] = $ans->stateTxt;
    //         }
    //     }

    //     return $list;
    // }

    


}