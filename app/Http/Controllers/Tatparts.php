<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Partcombrand;

class Tatparts
{

    protected $domain = 'https://service.tradesoft.ru/3/';
    protected $login = 'Meleuzboston';
    protected $psw = 'Suburbz13';
    protected $tatpartslogin = '89174500800@mail.ru';
    protected $tatpartspsw = 'Suburbz13';

    public function get_brands_list ($code = 123456) {

        $options = (object) array(
            'provider' => 'tatparts_ru',
            'login'=> $this->tatpartslogin,
            'password' => $this->tatpartspsw,
            'code' => $code
        );
        $response = Http::post($this->domain, [
            'service' => 'provider',
            'action' => 'getProducerList',
            'user'=> $this->login,
            'password' => $this->psw,
            'container' => [
                $options
                
            ]
        ]);
        $answer = json_decode($response->getBody());
        if (property_exists($answer, 'container') && property_exists($answer->container[0], 'data')) {
            return $answer->container[0]->data;
        }

         return [];
    }

    public function get_parts_list ($code = 'K', $brand = 'KNECHT/MAHLE') {

        $options = (object) array(
            'provider' => 'tatparts_ru',
            'login'=> $this->tatpartslogin,
            'password' => $this->tatpartspsw,
            'code' => $code,
            'producer' => $brand
        );
        $response = Http::post($this->domain, [
            'service' => 'provider',
            'action' => 'getPriceList',
            'user'=> $this->login,
            'password' => $this->psw,
            'container' => [
                $options
                
            ]
        ]);
        $answer = json_decode($response->getBody());
        if (property_exists($answer, 'container') && property_exists($answer->container[0], 'data')) {
            return $answer->container[0]->data;
        }

         return [];
    }

    public function get_provider_list () {
        $login = base64_encode($this->login.':'.$this->psw);
        $response = Http::post($this->domain, [
            'service' => 'provider',
            'action' => 'GetProviderList',
            'user'=> $this->login,
            'password' => $this->psw
        ]);
        dd(json_decode($response->getBody()));

         return $answer = json_decode($response->getBody());
    }


    public function getCheckout ($data) {
        $options = (object) array(
            'provider' => 'tatparts_ru',
            'login'=> $this->tatpartslogin,
            'password' => $this->tatpartspsw,
            'code' => $data['info'][0]['code'],
            'producer' => $data['info'][0]['brand'],
            'itemHash' => $data['info'][0]['part_code']
        );
        $response = Http::post($this->domain, [
            'service' => 'provider',
            'action' => 'PreOrderSearch',
            'user'=> $this->login,
            'password' => $this->psw,
            'container' => [
                $options
                
            ]
        ]);
        $answer = json_decode($response->getBody());
        dd($answer);
        if (property_exists($answer, 'container') && property_exists($answer->container[0], 'data')) {
            return $answer->container[0]->data;
        }

         return [];
    }



    


}