<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Partcombrand;

class PartCom
{

    protected $domain = 'https://www.part-kom.ru/engine/api/v3';
    protected $login = 'meleuzboston2';
    protected $psw = 'meleuzboston2';

    public function get_brands_list ($code) {
        $login = base64_encode($this->login.':'.$this->psw);
        $response = Http::withHeaders([
            'Authorization'=>'Basic ['.$login.']',
            'Accept'=>'application/json',
            'Content-type'=>'application/json'
        ])->get($this->domain.'/search/brands', [
            'number' => $code
        ]);

         return $answer = json_decode($response->getBody());
    }

    public function get_parts_list ($code, $brand) {
        if (Partcombrand::where('brand', $brand)->exists()) {
            $maker_id = Partcombrand::where('brand', $brand)->first()->id;
            $login = base64_encode($this->login.':'.$this->psw);
            $response = Http::withHeaders([
                'Authorization'=>'Basic ['.$login.']',
                'Accept'=>'application/json',
                'Content-type'=>'application/json'
            ])->get($this->domain.'/search/parts', [
                'number' => $code,
                'maker_id' => (string) $maker_id,
                'find_substitutes' => true
            ]);
            
            return $answer = json_decode($response->getBody());
        }

        return [];

        
    }

    public function getCheckout ($data) {
        $login = base64_encode($this->login.':'.$this->psw);
        $comment = mt_rand(100000, 999999);
        $item = (object) array(
            'detailNum'=>$data['info'][0]['code'],
            'makerId'=>$data['info'][0]['makerId'],
            'description'=>$data['info'][0]['name'],
            'price'=>$data['info'][0]['price'],
            'providerId'=>$data['info'][0]['providerId'],
            'quantity'=>$data['mount'][0],
            'providerId'=>$data['info'][0]['providerId'],
            'comment'=>$comment,
            'minOrder'=>$data['info'][0]['upakovka']
        );
            $response = Http::withHeaders([
                'Authorization'=>'Basic ['.$login.']',
                'Accept'=>'application/json',
                'Content-type'=>'application/json'
            ])->post($this->domain.'/order', [
                'flagTest' => false,
                'orderItems' => [$item]
            ]);
        if ($response) {
            return ['order_id' => $comment, 'count'=> $data['mount'][0], 'sum' =>$data['mount'][0]*$data['info'][0]['price']];
        }
    
        return json_decode($response->getBody())[0]->errorMessage;
    }

    public function getOrders () {
        $list = [];
        $login = base64_encode($this->login.':'.$this->psw);
        $response = Http::withHeaders([
            'Authorization'=>'Basic ['.$login.']',
            'Accept'=>'application/json',
            'Content-type'=>'application/json'
        ])->get('https://www.part-kom.ru/engine/api/v1/motion');
        $answer = json_decode($response->getBody());
        if (is_array($answer)) {
            foreach ($answer as $ans) {
                $key = $ans->comment;
                $list[$key] = $ans->stateTxt;
            }
        }

        return $list;
    }

    


}