<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use CodeDredd\Soap\Facades\Soap;

class Rossko
{
    protected $domain = 'http://api.rossko.ru/service/v2.1';
    protected $key1 = '2a3a00dd4368210a2d7097f79fe0733a';
    protected $key2 = '3036ee8067fc95e288ac734a75c6b1bb';
    protected $delivery_id = '000000002';
    protected $address_id = 103074;
    protected $payment_id = 1;
    protected $requisite_id = 23381;
    protected $name = 'Рустем';
    protected $phone = '+7(937)305-29-79';
    protected $delivery_parts = true;
    protected $status = [
        0 => 'ждёт подтверждения',
        1 => 'комплектуется',
        2 => 'отгружено',
        3 => 'готово к отгрузке',
        5 => 'ожидаем поступление',
        6 => 'на складе филиала',
        7 => 'нет в наличии',
        8 => 'отменён клиентом',
        9 => 'просрочен',
        31 =>'ожидаем товар на складе',
        32 =>'возврат на согласовании',
        33 =>'товар на экспертизе',
        34 =>'возврат отклонён',
        35 =>'возврат частично отклонён',
        36 =>'товар возвращён'
    ];





    public function getCheckoutDetails () {

        $response = Soap::baseWsdl($this->domain.'/GetCheckoutDetails')
        ->GetCheckoutDetails([
            'KEY1' => $this->key1,
            'KEY2' => $this->key2,
        ]);
    
        dd($response->json());
    }

    public function get_parts_list ($code, $brand) {

        $response = Soap::baseWsdl($this->domain.'/GetSearch')
        ->GetSearch([
            'KEY1' => $this->key1,
            'KEY2' => $this->key2,
            'text' => $brand.' '.$code,
            'delivery_id' => $this->delivery_id,
            'address_id' => $this->address_id
        ]);
    
        return $response->json();
    }

    public function getCheckout ($code, $brand, $count, $stock) {

        $response = Soap::baseWsdl($this->domain.'/GetCheckout')
        ->GetCheckout([
            'KEY1' => $this->key1,
            'KEY2' => $this->key2,
            'delivery' => array(
                'delivery_id' => $this->delivery_id,
                'address_id' => $this->address_id
            ),
            'payment' => array(
                'payment_id'        => $this->payment_id,
                'requisite_id'      => $this->requisite_id
            ),
            'contact' => array(
                'name'    => $this->name,
                'phone'   => $this->phone
            ),
            'delivery_parts' => $this->delivery_parts,
            'PARTS' => array(
                array(
                    'partnumber' => $code,
                    'brand'      => $brand,
                    'count'      => $count,
                    'stock'      => $stock
                ),
            )
            
        ]);
    
        return $response->json();
    }

    public function getOrders () {

        $response = Soap::baseWsdl($this->domain.'/GetOrders')
        ->GetOrders([
            'KEY1' => $this->key1,
            'KEY2' => $this->key2,
            'limit' => 100
        ]);
        $answer = $response->json();
        $list = [];
        if (array_key_exists('OrdersList', $answer['OrdersResult'])) {
            foreach ($answer['OrdersResult']['OrdersList']['Order'] as $order) {
                $list[$order['id']] = $this->status[$order['parts']['part'][0]['status']];
            }
        }


        return $list;
    }



}