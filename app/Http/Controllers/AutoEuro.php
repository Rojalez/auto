<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


class AutoEuro
{

    protected $domain = 'api.autoeuro.ru/api/v-1.0';
    protected $key = 'okwQE8F6z6OfAGN5iPrq1VvRwvxqMT8A9PQEZzyEmC3MdaZm0xqoXd27XGqw';
    protected $subdivision_key = 'ogeRtaAVTbn%2FgjvNpHEZxi0FXtlvnXv8GaUON7FfMMbY4DF3brfW6H1mxYDjkR7wNHIqYZrxHMMzutXD%2FsOKHETQR5lXjQBwOkTv7Z3cFZHios3D8dxjkmx96GUEVLSaqV358Srp0Om0qFfQfRDP0PgWcKXH%2B5Cwdo8W5w2ljoS2rTwr0clpcP3NNsIUhiFd2VYW1DhzRpOm%2FGACDnT5Yv2UZRI22if0ZltkrXQ5%2B8WntXaoLWCVPo6nXL1rrkvNXSgwfwHDwcrADwBljtpeHI2dDVwMPHNAF%2BvFSAU51oTlAHyyq%2FnJDDP5%2BZQbV4sMaYGXmWW0il%2B4zxlmjiT4qyE4jnyWsqOoaQ9SVTDyV8A%3D';
    protected $delivery_key1 = 'Zid3sPWIUfEZXeXVuy8e46Zr1MwD704huFO0nxypa7DxUyB%2BlF1Vh4dMAnAa3qxhhI272D8npAC0Gl%2FUWNynsfbWxSyjqG9S9fQ%2Bk1GeP1xCjg5J470ZnoZeTHsZICym%2BEUUZ0wYVPCUbjbnHwTR3c227AGXDBbI4gwxzixWriVVNMnrsVRfj0CN0xrPo29PVpLTJLW32ayMBmvtbzbBsBl%2BMwQAq8F2rHjsuPEMpLOZcid62c0qO5w4VZAoJ%2FVQm2fgjoYOlbAUkI8yBswMeQ%3D%3D';
    protected $delivery_key2 = 'Zid3sPWIUfEZXeXVuy8e46Zr1MwD704huFO0nxypa7DxUyB%2BlF1Vh4dMAnAa3qxhhI272D8npAC0Gl%2FUWNynsfbWxSyjqG9S9fQ%2Bk1GeP1xCjg5J470ZnoZeTHsZICym%2BEUUZ0wYVPCUbjbnHwTR3c227AGXDBbI4gwxzixWriVVNMnrsVRfj0CN0xrPo29PVpLTJLW32ayMBmvtbzbBsBl%2BMwQAq8F2rHjsuPEMpLPnVW2ArePTNSGgIVwqLLOBWtHkw6SBfIZ3R%2FifCOn%2Faw%3D%3D';


    public function get_brands_list ($code) {
        $response = Http::get($this->domain.'/shop/stock_items/json/'.$this->key, [
            'code' => $code,
        ]);

        return $answer = json_decode($response->getBody());
    }

    public function get_parts_list ($code, $brand) {
        $response = Http::get($this->domain.'/shop/stock_items/json/'.$this->key, [
            'code' => $code,
            'brand' => $brand
        ]);

        return json_decode($response->getBody());
    }

    public function getCheckout ($key, $count, $house) {

        $order = (object) array("order_key" => $key , "quantity" => (string) $count);
        if ($house == '_____QOLM') {
            $delivery_key = $this->delivery_key1;
        } else {
            $delivery_key = $this->delivery_key2;
        }
        $comment = mt_rand(100000, 999999);


        $response = Http::get($this->domain.'/shop/order_stock/json/'.$this->key.'?delivery_key='.$delivery_key.'&subdivision_key='.$this->subdivision_key.
        '&stock_items=[{"order_key": "'.$key.'", "quantity": "'.$count.'"}]'.'&comment='.$comment);
    
        return ['order_id' => $comment, 'response' => json_decode($response->getBody())];
    }

    public function getOrders () {


        // if (is_array($answer)) {
        //     foreach ($answer as $ans) {
        //         $key = $ans->did;
        //         $list[$key] = $ans->status;
        //     }
        // }
        $response = Http::get($this->domain.'/shop/ordered_items/json/'.$this->key);
        $answer = json_decode($response->getBody());
        $list = [];
        if (!property_exists($response, 'ERROR')) {

            foreach ($answer->DATA as $ans) {
                $key = $ans->comment;
                $list[$key] = $ans->tovar_state;
            }
        
        }
        

        return $list;
    }


}