<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AutoEuro;
use App\Http\Controllers\ForumAuto;
use App\Http\Controllers\Rossko;
use App\Http\Controllers\PartCom;
use App\Http\Controllers\Tatparts;
use App\Http\Controllers\Armtek;
use Illuminate\Support\Facades\Auth;
use App\Models\Diapazon;
use App\Models\Postavshiki;
use App\Http\Controllers\Fapi;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class Api
{
    protected $brands_list = [];
    protected $parts_list = [];
    protected $crosses_list_this_brand = [];
    protected $crosses_list = [];
    protected $levam = [];
    protected $part_name = '';
    public $guid;

    public function get_brands_list ($code) {
        $postavshik = Postavshiki::find(2);
        if ($postavshik->status == 'Включен') {
            $this->get_brands_list_auto_euro ($code);
        }
        $postavshik = Postavshiki::find(3);
        if ($postavshik->status == 'Включен') {
            $this->get_brands_list_forum_auto ($code);
        }
        $postavshik = Postavshiki::find(4);
        if ($postavshik->status == 'Включен') {
            $this->get_brands_list_partcom ($code);
        } 
        // $postavshik = Postavshiki::find(5);
        // if ($postavshik->status == 'Включен') {
        //     $this->get_brands_list_armtek ($code);
        // } 
        $postavshik = Postavshiki::find(6);
        if ($postavshik->status == 'Включен') {
            $this->get_brands_list_tatparts ($code);
        } 

        $this->get_brands_list_fapi ($code);
        
        
        return $this->brands_list;
    }

    public function get_parts_list ($code, $brand) {
        $postavshik = Postavshiki::find(1);
        if ($postavshik->status == 'Включен') {
            $this->get_parts_list_rossko ($code, $brand);
        } 
        $postavshik = Postavshiki::find(2);
        if ($postavshik->status == 'Включен') {
            $this->get_parts_list_auto_euro ($code, $brand);
        }
        $postavshik = Postavshiki::find(3);
        if ($postavshik->status == 'Включен') {
            $this->get_parts_list_forum_auto ($code, $brand);
        }
        $postavshik = Postavshiki::find(4);
        if ($postavshik->status == 'Включен') {
            $this->get_parts_list_partcom ($code, $brand);
        } 
        // $postavshik = Postavshiki::find(5);
        // if ($postavshik->status == 'Включен') {
        //     $this->get_parts_list_armtek ($code, $brand);
        // } 
        $postavshik = Postavshiki::find(6);
        if ($postavshik->status == 'Включен') {
            $this->get_parts_list_tatparts ($code, $brand);
        } 
        
        return ['levam' => $this->levam,'name' => $this->part_name,'code' => $code, 'brand' => $brand,'parts' => $this->parts_list, 'crosses_brand' => $this->crosses_list_this_brand, 'crosses' => $this->crosses_list];
    }




    protected function get_brands_list_auto_euro ($code) {
        $postav = new AutoEuro;
        $brands_array = $postav->get_brands_list($code);
		
        if (!property_exists($brands_array, 'ERROR')) {
          if (property_exists($brands_array->DATA, 'VARIANTS')) {
            foreach ($brands_array->DATA->VARIANTS as $brand) {
                if (!array_key_exists($brand->brand, $this->brands_list)){
                    $this->brands_list[$brand->brand] = $brand;
                }
                
            }
          } else {
            
          }
        }
    }

    protected function get_brands_list_forum_auto ($code) {
        $postav = new ForumAuto;
        $brands_array = $postav->get_brands_list($code);
        
        if (is_array($brands_array)) {
            foreach ($brands_array as $brand) {
                if (!array_key_exists($brand->brand, $this->brands_list)){
                    $this->brands_list[$brand->brand] = $brand;
                }
                
            }
        }
    }

    protected function get_brands_list_fapi ($code) {
        $fapi = new Fapi;
        $brands_array = $fapi->brandsLists($code);
        
        if (property_exists($brands_array, 'manufacturerList') && property_exists($brands_array->manufacturerList, 'mf')) {
            foreach ($brands_array->manufacturerList->mf as $brand) {
                if (!array_key_exists($brand->ds, $this->brands_list)){
                    $this->brands_list[$brand->ds] = ['code'=>$code, 'brand'=>$brand->ds];
                }
                
            }
        }
    }

    protected function get_brands_list_partcom ($code) {
        $fapi = new PartCom;
        $brands_array = $fapi->get_brands_list($code);
        if (is_array($brands_array)) {
             foreach ($brands_array as $brand) {
                if (!array_key_exists($brand->name, $this->brands_list)){
                    $this->brands_list[$brand->name] = ['code'=>$code, 'brand'=>$brand->name];
                }

            }
        }
    }

    protected function get_brands_list_tatparts ($code) {
        $fapi = new Tatparts;
        $brands_array = $fapi->get_brands_list($code);
        if (is_array($brands_array)) {
             foreach ($brands_array as $brand) {
                if (!array_key_exists($brand->producer, $this->brands_list)){
                    $this->brands_list[$brand->producer] = ['code'=>$brand->code, 'brand'=>$brand->producer, 'name'=>$brand->caption];
                }
            }
        }
    }

    protected function get_brands_list_armtek ($code) {
        $fapi = new Armtek;
        $brands_array = $fapi->get_brands_list($code);
        if (is_array($brands_array)) {
             foreach ($brands_array as $brand) {
                if (!array_key_exists($brand->BRAND, $this->brands_list)){
                    $this->brands_list[$brand->BRAND] = ['code'=>$brand->PIN, 'brand'=>$brand->BRAND, 'name'=>$brand->NAME];
                }
            }
        }
    }


    protected function get_parts_list_auto_euro ($code, $brand) {
        $postav = new AutoEuro;
        $brands_array = $postav->get_parts_list($code, $brand);
        $skidka = $this->skidka();
        if ($brands_array != null && !property_exists($brands_array, 'ERROR')) {
            foreach ($brands_array->DATA->CODES as $part) {
                if ($part->from_warehouse_id == '____10OLM' || $part->from_warehouse_id == '_____QOLM') {
                    $this->guid++;
                    if ($part->packing == 0) {
                        $part->packing = 1;
                    }
                    $this->parts_list[] = ['postav' => 'Авто-Евро', 'quid' => $part->order_key.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->order_key, 'house' => $part->from_warehouse_id, 'upakovka' => $part->packing, 'code' => $part->code, 'name' => $part->name, 
                    'brand' => $part->maker, 'amount' => $part->amount, 'price' => $part->price, 'srok' => $part->order_term ];
                    if ($this->part_name == '') {
                        $this->part_name = $part->name;
                    }
                }

            }

            foreach ($brands_array->DATA->CROSSES as $cross) {
                if ($cross->from_warehouse_id == '____10OLM' || $cross->from_warehouse_id == '_____QOLM') {
                    $this->guid++;
                    if ($cross->maker == $brand) {
                        if ($cross->packing == 0) {
                            $cross->packing = 1;
                        }
                        $this->crosses_list_this_brand[] = ['postav' => 'Авто-Евро', 'quid' => $part->order_key.$this->guid,'house' => $cross->from_warehouse_id, 'diapazon'=> $this->diapazon($cross->price), 'skidka'=>$skidka, 'part_code' => $cross->order_key, 'upakovka' => $cross->packing, 'code' => $cross->code, 'name' => $cross->name, 
                        'brand' => $cross->maker, 'amount' => $cross->amount, 'price' => $cross->price, 'srok' => $cross->order_term ];
                    } else {
                        if ($cross->packing == 0) {
                            $cross->packing = 1;
                        }
                        $this->crosses_list[$cross->maker][] = ['postav' => 'Авто-Евро', 'skidka'=>$skidka, 'diapazon'=> $this->diapazon($cross->price), 'part_code' => $cross->order_key,'house' => $cross->from_warehouse_id, 'upakovka' => $cross->packing, 'code' => $cross->code, 'name' => $cross->name, 
                        'brand' => $cross->maker, 'amount' => $cross->amount, 'price' => $cross->price, 'srok' => $cross->order_term ];
                    }
                }
            }
        }

        
    }

    protected function get_parts_list_forum_auto ($code, $brand) {
        $postav = new ForumAuto;
        $brands_array = $postav->get_parts_list($code, $brand);
        $skidka = $this->skidka();
        
        if (is_array($brands_array)) {
            foreach ($brands_array as $part) {
                $this->guid++;
                    $this->parts_list[] = ['postav' => 'Форум-Авто','quid' => $part->gid.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->gid,'upakovka' => $part->kr, 'code' => $part->art, 'name' => $part->name, 
                    'brand' => $part->brand, 'amount' => $part->num, 'price' => $part->price, 'srok' => $part->d_deliv ];
                    if ($this->part_name == '') {
                        $this->part_name = $part->name;
                    }
            }
        

        $crosses_array = $postav->get_parts_list_cross($code, $brand);

        
                foreach ($crosses_array as $part) {
                    $this->guid++;
                    if ($part->brand == $brand) {
                        $this->crosses_list_this_brand[] = ['postav' => 'Форум-Авто','quid' => $part->gid.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->gid, 'upakovka' => $part->kr, 'code' => $part->art, 'name' => $part->name, 
                        'brand' => $part->brand, 'amount' => $part->num, 'price' => $part->price, 'srok' => $part->d_deliv ];
                    } else {
                        $this->crosses_list[$part->brand][] = ['postav' => 'Форум-Авто', 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->gid, 'upakovka' => $part->kr, 'code' => $part->art, 'name' => $part->name, 
                        'brand' => $part->brand, 'amount' => $part->num, 'price' => $part->price, 'srok' => $part->d_deliv ];
                    }

                }
            
        }
    }


    protected function get_parts_list_tatparts ($code, $brand) {
        $postav = new Tatparts;
        $brands_array = $postav->get_parts_list($code, $brand);
        $skidka = $this->skidka();
        
        if (is_array($brands_array)) {
            foreach ($brands_array as $part) {
                $this->guid++;
                if ($part->code == $code && $part->producer == $brand) {
                    $this->parts_list[] = ['postav' => 'Tatparts','quid' => $part->itemHash.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->itemHash,'upakovka' => $part->minquantity, 'code' => $part->code, 'name' => $part->caption, 
                    'brand' => $part->producer, 'amount' => $part->rest, 'price' => $part->price, 'srok' => $part->deliverydays_max ];
                    if ($this->part_name == '') {
                        $this->part_name = $part->caption;
                    }
                } else if ($part->producer == $brand) {
                    $this->crosses_list_this_brand[] = ['postav' => 'Tatparts','quid' => $part->itemHash.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->itemHash,'upakovka' => $part->minquantity, 'code' => $part->code, 'name' => $part->caption, 
                    'brand' => $part->producer, 'amount' => $part->rest, 'price' => $part->price, 'srok' => $part->deliverydays_max ];
                } else {
                    $this->crosses_list[$part->producer][] = ['postav' => 'Tatparts','quid' => $part->itemHash.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->itemHash,'upakovka' => $part->minquantity, 'code' => $part->code, 'name' => $part->caption, 
                    'brand' => $part->producer, 'amount' => $part->rest, 'price' => $part->price, 'srok' => $part->deliverydays_max ];
                }

            }

        }
    }

    protected function get_parts_list_armtek ($code, $brand) {
        $postav = new Armtek;
        $brands_array = $postav->get_parts_list($code, $brand);
        $skidka = $this->skidka();
        
        if (is_array($brands_array)) {
            foreach ($brands_array as $part) {
                $this->guid++;
                if ($part->PIN == $code && $part->BRAND == $brand) {
                    $this->parts_list[] = ['postav' => 'Армтек','quid' => $part->ARTID.$this->guid, 'KEYZAK'=>$part->KEYZAK, 'diapazon'=> $this->diapazon($part->PRICE), 'skidka'=>$skidka, 'part_code' => $part->ARTID,'upakovka' => $part->RDPRF, 'code' => $part->PIN, 'name' => $part->NAME, 
                    'brand' => $part->BRAND, 'amount' => (integer) $part->RVALUE, 'price' => $part->PRICE, 'srok' => $part->WRNTDT ];
                    if ($this->part_name == '') {
                        $this->part_name = $part->NAME;
                    }
                } else if ($part->BRAND == $brand) {
                    $this->crosses_list_this_brand[] = ['postav' => 'Армтек','quid' => $part->ARTID.$this->guid, 'KEYZAK'=>$part->KEYZAK, 'diapazon'=> $this->diapazon($part->PRICE), 'skidka'=>$skidka, 'part_code' => $part->ARTID,'upakovka' => $part->RDPRF, 'code' => $part->PIN, 'name' => $part->NAME, 
                    'brand' => $part->BRAND, 'amount' => (integer) $part->RVALUE, 'price' => $part->PRICE, 'srok' => $part->WRNTDT ];
                } else {
                    $this->crosses_list[$part->BRAND][] = ['postav' => 'Армтек','quid' => $part->ARTID.$this->guid, 'KEYZAK'=>$part->KEYZAK, 'diapazon'=> $this->diapazon($part->PRICE), 'skidka'=>$skidka, 'part_code' => $part->ARTID,'upakovka' => $part->RDPRF, 'code' => $part->PIN, 'name' => $part->NAME, 
                    'brand' => $part->BRAND, 'amount' => (integer) $part->RVALUE, 'price' => $part->PRICE, 'srok' => $part->WRNTDT ];
                }

            }

        }
    }


    protected function get_parts_list_partcom ($code, $brand) {
        $postav = new Partcom;
        $brands_array = $postav->get_parts_list($code, $brand);
        $skidka = $this->skidka();
        if (is_array($brands_array)) {
            foreach ($brands_array as $part) {
                $this->guid++;
                if ($part->detailGroup == 'Original') {
                    $this->parts_list[] = ['postav' => 'ПартКом','quid' => $part->number.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->number,'upakovka' => $part->minQuantity, 'code' => $part->number, 'name' => $part->description, 
                    'brand' => $part->maker, 'amount' => $part->quantity, 'makerId'=>$part->makerId, 'price' => ceil($part->price), 'srok' => $part->guaranteedDays, 'providerId'=>$part->providerId ];
                    if ($this->part_name == '') {
                        $this->part_name = $part->description;
                    }
                } else if ($part->detailGroup == 'ReplacementOriginal') {
                    $this->crosses_list_this_brand[] = ['postav' => 'ПартКом','quid' => $part->number.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->number,'upakovka' => $part->minQuantity, 'code' => $part->number, 'name' => $part->description, 
                    'brand' => $part->maker, 'amount' => $part->quantity, 'makerId'=>$part->makerId, 'price' => ceil($part->price), 'srok' => $part->guaranteedDays, 'providerId'=>$part->providerId ];
                } else {
                    $this->crosses_list[$part->maker][] = ['postav' => 'ПартКом','quid' => $part->number.$this->guid, 'diapazon'=> $this->diapazon($part->price), 'skidka'=>$skidka, 'part_code' => $part->number,'upakovka' => $part->minQuantity, 'code' => $part->number, 'name' => $part->description, 
                    'brand' => $part->maker, 'amount' => $part->quantity, 'makerId'=>$part->makerId, 'price' => ceil($part->price), 'srok' => $part->guaranteedDays, 'providerId'=>$part->providerId ];
                }
            }
        }
    }

    protected function get_parts_list_rossko ($code, $brand) {
        $postav = new Rossko;
        $brands_array = $postav->get_parts_list($code, $brand);
        $skidka = $this->skidka();
        if ($brands_array['SearchResult']['success']) {
            $partsList1 = $brands_array['SearchResult']['PartsList']['Part'];
            
                foreach ($partsList1 as $partsList) {
                    if (array_key_exists('stocks', $partsList1)) {
                    foreach ($partsList['stocks']['stock'] as $part) {
                        $this->guid++;
                            $this->parts_list[] = ['postav' => 'Росско', 'quid' => $part['id'].$this->guid, 'diapazon'=> $this->diapazon($part['price']), 'skidka'=>$skidka, 'part_code' => $part['id'], 'upakovka' => $part['multiplicity'],'code' => $partsList['partnumber'], 'name' => $partsList['name'],
                            'brand' => $partsList['brand'], 'amount' => $part['count'], 'price' => (float) $part['price'], 'srok' => $part['delivery'] ];
                            if ($partsList['name'] == '') {
                                $this->part_name = $partsList['name'];
                            }
                    }
                }
                    if (array_key_exists('crosses', $partsList) && $partsList['crosses']) {
                        foreach ($partsList['crosses']['Part'] as $partsList) {
                            foreach ($partsList['stocks']['stock'] as $part) {
                                $this->guid++;
                                if ($partsList['brand'] == $brand) {
                                    $this->crosses_list_this_brand[] = ['postav' => 'Росско', 'quid' => $part['id'].$this->guid, 'diapazon'=> $this->diapazon($part['price']), 'skidka'=>$skidka, 'part_code' => $part['id'], 'upakovka' => $part['multiplicity'], 'code' => $partsList['partnumber'], 'name' => $partsList['name'],
                                    'brand' => $partsList['brand'], 'amount' => $part['count'], 'price' => (float) $part['price'], 'srok' => $part['delivery'] ];
                                } else {
                                    $this->crosses_list[$partsList['brand']][] = ['postav' => 'Росско', 'quid' => $part['id'].$this->guid, 'diapazon'=> $this->diapazon($part['price']), 'skidka'=>$skidka, 'part_code' => $part['id'], 'upakovka' => $part['multiplicity'], 'code' => $partsList['partnumber'], 'name' => $partsList['name'],
                                    'brand' => $partsList['brand'], 'amount' => $part['count'], 'price' => (float) $part['price'], 'srok' => $part['delivery'] ];
                                }
                
                            }
                        }
                    }
                }
            
        }

    }


    public function to_basket ($data) {
        if ($data['info'][0]['postav'] == 'Росско') {
            $postav = new Rossko;
            $response = $postav->getCheckout($data['info'][0]['code'], $data['info'][0]['brand'], $data['mount'][0], $data['info'][0]['part_code']);
            //dd($response);
            if (array_key_exists('ItemsList', $response['CheckoutResult'])) {
                return ['order_id'=>$response['CheckoutResult']['ItemsList']['Item'][0]['order_id'], 'count' => (int) $response['CheckoutResult']['ItemsList']['Item'][0]['count'], 'sum'=> (float) $response['CheckoutResult']['ItemsList']['Item'][0]['total_price']];
            } else {
                return ['message'=>$response['CheckoutResult']['ItemsErrorList']['ItemError'][0]['message']];
            }
        } else if ($data['info'][0]['postav'] == 'Авто-Евро') {
            $postav = new AutoEuro;
            $response = $postav->getCheckout($data['info'][0]['part_code'], $data['mount'][0], $data['info'][0]['house']);
            if (!property_exists($response['response'], 'ERROR')) {
                return ['order_id'=>$response['order_id'], 'count' => $data['mount'][0], 'sum' => $data['mount'][0] * $data['info'][0]['price']];
            } else {
                return ['message'=>$response['response']->ERROR->description];
            }
        } else if ($data['info'][0]['postav'] == 'Форум-Авто') {
            $postav = new ForumAuto;
            $response = $postav->getCheckout($data['info'][0]['part_code'], $data['mount'][0]);
            
            if (is_array($response)) {
                return ['order_id'=>$response[0]->did, 'count' => $response[0]->arTovs[0]->k1, 'sum' => $response[0]->arTovs[0]->sum ];
            } else {
                return ['message'=>$response->errors->FaultDetail];
            }
        } else if ($data['info'][0]['postav'] == 'ПартКом') {
            $postav = new PartCom;
            $response = $postav->getCheckout($data);
            if (is_array($response)) {
                return ['order_id'=>$response['order_id'], 'count' => $response['count'], 'sum' => $response['sum'] ];
            } else {
                return ['message'=>$response];
            }
        } else if ($data['info'][0]['postav'] == 'Tatparts') {
                return ['order_id'=>'not_ordered', 'count' => $data['mount'][0], 'sum' =>$data['info'][0]['price']*$data['mount'][0] ];
        } else if ($data['info'][0]['postav'] == 'Армтек') {
            $postav = new Armtek;
            $response = $postav->getCheckout($data);
            if (is_array($response)) {
                return ['order_id'=>$response['order_id'], 'count' => $response['count'], 'sum' => $response['sum'] ];
            } else {
                return ['message'=>$response];
            }
        }

    }

    public function  orders_list () {
        $api = new ForumAuto;
        $list1 = $api->getOrders();
        $api = new Rossko;
        $list2 = $api->getOrders();
        $api = new AutoEuro;
        $list3 = $api->getOrders();
        $api = new PartCom;
        $list4 = $api->getOrders();
        $lists = $list1+$list2+$list3+$list4;
        return $lists;
    }

    public function skidka () {
        $procent = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $admin = $user->hasRole('admin');
            if (!$admin) {
                $procent = $user->procent;
            } else if($admin && Session::has('user_id')) {
                $user = User::find(Session::get('user_id'));
                $procent = $user->procent;
            }
        }
        return $procent;
    }

    public function diapazon($price) {

        if (!is_numeric($price))
        {
            $price = (int) $price;
        }
        $price = round($price, 0);
        $diapazons = Diapazon::all();
        foreach ($diapazons as $diapazon) {
            if ($price >= $diapazon->from_price && $price <= $diapazon->to_price) {
                return $diapazon->procent;
            }
        }
    }








    


}