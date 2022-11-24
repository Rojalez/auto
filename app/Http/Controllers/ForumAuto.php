<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ForumAuto
{

    protected $domain = 'https://api.forum-auto.ru/v2';
    protected $login = '495438_mogucheva';
    protected $psw = 'EPeBwxdWAC';


    public function get_brands_list ($code) {
        $response = Http::get($this->domain.'/listBrands', [
            'login' => $this->login,
            'pass' => $this->psw,
            'art' => $code,
        ]);
            
        return $answer = json_decode($response->getBody());
    }

    public function get_parts_list ($code, $brand) {
        $response = Http::get($this->domain.'/listGoods', [
            'login' => $this->login,
            'pass' => $this->psw,
            'cross' => 0,
            'art' => $code,
            'br' => $brand,
        ]);

        return $answer = json_decode($response->getBody());
    }

    public function get_parts_list_cross ($code, $brand) {
        $response = Http::get($this->domain.'/listGoods', [
            'login' => $this->login,
            'pass' => $this->psw,
            'cross' => 1,
            'art' => $code,
            'br' => $brand,
        ]);

        return $answer = json_decode($response->getBody());
    }


    public function getCheckout ($key, $count) {
        $param = array(
            'login' => $this->login,
            'pass' => $this->psw,
            'tid' => $key,
            'num' => $count
        );
        $response = Http::get($this->domain.'/addGoodsToOrder', $param);
    
        return json_decode($response->getBody());
    }

    public function deleteOrder ($order) {
        $param = array(
            'login' => $this->login,
            'pass' => $this->psw,
            'did' => $order
        );
        $response = Http::get($this->domain.'/cancelOrder', $param);
        dd(json_decode($response->getBody()));
        return json_decode($response->getBody());
    }

    public function getOrders () {

        $param = array(
            'login' => $this->login,
            'pass' => $this->psw,
            'did' => 0
        );

        $response = Http::get($this->domain.'/listOrders', $param);
        $answer = json_decode($response->getBody());
        $list = [];

        if (is_array($answer)) {
            foreach ($answer as $ans) {
                $key = $ans->did;
                $list[$key] = $ans->status;
            }
        }

        return $list;
    }



}