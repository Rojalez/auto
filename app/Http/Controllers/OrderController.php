<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Api;
use App\Models\Part;
use App\Models\Order;
use App\Models\User;
use App\Models\Postavshiki;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    //Возвращает страницу корзины
    public function index()
    {
        $users = User::all();
        return Inertia::render('Frontend/Basket', ['users' => $users]);
    }

    public function orders(Request $request)
    {
        $orders = Order::query();

        if ($request->id != null) {
            $orders->where('id', $request->id);
        }
        
        if ($request->phone != null) {
            $phone = $request->phone;
            $orders->whereHas('user', function ($query) use ($phone) {
                $query->where('phone', $phone);
            });
        }
        if ($request->from != null) {
            $orders->where('created_at', '>=' ,$request->from);
        }
        if ($request->to != null) {
            $orders->where('created_at', '<=' ,$request->to);
        }

        $orders = $orders->with('user')->orderby('id', 'desc')->get();
    

        $api = new Api;
        $lists = $api->orders_list();
        foreach ($orders as $order) {
            foreach($order->parts as $part) {
                if (array_key_exists($part->key, $lists)) {
                    if($part->status != $lists[$part->key]) {
                        $part->status = $lists[$part->key];
                        $part->save();
                    }
               } else if ($part->key == 'not_ordered' && $part->status == null) {
                        $part->status = 'В обработке';
                        $part->save();
               }
                
            }
        }

        return Inertia::render('Orders', ['data' => $orders]);
    }
    public function providers(Request $request)
    {
        $parts = Part::query();
        if ($request->key != null) {
                $parts->where('key', $request->key);
        }
        if ($request->code != null) {
            $parts->where('code', $request->code);
        }
        if ($request->status != null) {
            if ($request->status == 'Активные') {
                $parts->whereNotIn('status', ['Принят', 'Отказано']);
            } else {
                $parts->where('status', $request->status);
            }
            
        }
        if ($request->postavshik != null) {
            $parts->where('postavshik', $request->postavshik);
        }
        if ($request->brand != null) {
            $parts->where('brand', $request->brand);
        }
        $parts->where('key', '!=','not_ordered');
        $parts = $parts->orderBy('id', 'desc')->get();
        $providers = Postavshiki::where('status', '!=', 'Выключен')->get();
        return Inertia::render('Providers', ['data' => $parts, 'providers' => $providers]);
    }

    public function obrabotka(Request $request)
    {
        $parts = Part::query();
        $parts->where('key', 'not_ordered');
        if ($request->key != null) {
                $parts->where('key', $request->key);
        }
        if ($request->code != null) {
            $parts->where('code', $request->code);
        }
        if ($request->status != null) {
            if ($request->status == 'Активные') {
                $parts->whereNotIn('status', ['Принят', 'Отказано']);
            } else {
                $parts->where('status', $request->status);
            }
            
        }
        if ($request->postavshik != null) {
            $parts->where('postavshik', $request->postavshik);
        }
        if ($request->brand != null) {
            $parts->where('brand', $request->brand);
        }
        
        $parts = $parts->orderBy('id', 'desc')->get();
        $providers = Postavshiki::where('status', '!=', 'Выключен')->get();
        return Inertia::render('Obrabotka', ['data' => $parts, 'providers' => $providers]);
    }

    public function createOrder(Request $request)
    {
        
        $order = new Order;
        if (Auth::check() && Auth::user()->id == $request->client) {
            $request->client = 0;
            $order->user_id = Auth::id();
        } else if ($request->client != 0) {
            $order->user_id = $request->client;
        } else {
            $order->user_id = Auth::id();
        }
        
        $status = 0;
        $skidka = 0;
        $price = 0.0;
        $price_n = 0;
        $order->save();
        $summa_skidki =0;

        foreach ($request->data as $reg) {
            $api = new Api;
            $response = $api->to_basket($reg);
            $part = new Part;

            
            if (Auth::check() && Auth::user()->hasRole('admin') && $request->client == 0) {
                    $reg['info'][0]['diapazon'] = 0;
            }
            $part->order_id = $order->id;
            $part->name = $reg['info'][0]['name'];
            $part->code = $reg['info'][0]['code'];
            $part->price = $reg['info'][0]['price'];
            $part->srok = $reg['info'][0]['srok'];
            $part->postavshik = $reg['info'][0]['postav'];
            $part->brand = $reg['info'][0]['brand'];
            if ($request->client != 0) {
                $user = User::find($request->client);
                $reg['info'][0]['skidka'] = $user->procent;
            }
            
            if (!Auth::check() || !Auth::user()->hasRole('admin') || $request->client != 0) {
                $skidka = $reg['info'][0]['skidka'];
                $part->skidka = $reg['info'][0]['skidka'];
                $part->price_n = round(round($reg['info'][0]['price']) + round($reg['info'][0]['price'])*$reg['info'][0]['diapazon']/100);
            }
            
            if (array_key_exists('order_id', $response)) {
                $part->key = $response['order_id'];
                $part->sum = $response['sum'];
                if (!Auth::check() || !Auth::user()->hasRole('admin') || $request->client != 0) {
                    $part->sum_n = round((float) $response['sum'] + (float) $response['sum']*$reg['info'][0]['diapazon']/100);
                    $part->sum_s = round($part->sum_n * $reg['info'][0]['skidka']/100);
                    $part->total = $part->sum_n - $part->sum_s;
                    $price_n += $part->sum_n;
                    $summa_skidki +=$part->sum_s;
                } else {
                    $part->total = round((float)$response['sum']);
                }
                $part->amount = $response['count'];
                $price += $response['sum'];
            } else if (array_key_exists('message', $response)) {
                $part->key = $response['message'];
                $part->sum = 0;
                $part->amount = '0';
                $part->status = 'Ошибка при заказе';
            }
            
            $part->save();
            $status =1;
        }
        if (!Auth::check() || !Auth::user()->hasRole('admin') || $request->client != 0) {
            $order->skidka_s = $summa_skidki;
            $order->price_n = $price_n;
            $order->skidka = $skidka;
            $order->total = $order->price_n - $summa_skidki;
        } else {
            $order->total = $price;
        }
        
        $order->price = $price;
        $order->save();
        if ($status == 0) {
            $order->delete();
        }
        $request->session()->forget('basket');

        return redirect()->route('move');
        
        
    }
  
    //Добавляет товар в корзину
    public function store(Request $request)
    {
        if (!$request->session()->has('basket')) {
            $request->session()->put('basket', []);
        }

        if (!array_key_exists($request['quid'] , $request->session()->get('basket'))) {
            $request->session()->push('basket.'.$request['quid'].'.info', $request->all());
            $request->session()->push('basket.'.$request['quid'].'.mount', $request['upakovka']);
        } else {
            if ($request->session()->get('basket.'.$request['quid'].'.mount')[0] <= $request['amount'] ) {
                $mount = $request->session()->get('basket.'.$request['quid'].'.info')[0]['upakovka'];
                $count = $request->session()->pull('basket.'.$request['quid'].'.mount')[0];
                if ($count + $mount <= $request['amount']) {
                    $count = $count + $mount;
                }
                $request->session()->push('basket.'.$request['quid'].'.mount', $count);
            }
        }
        

        session()->save();
        
        return redirect()->back();
    }
  
    //Уменьшает количество товара в корзине
    public function update(Request $request)
    {
            if (array_key_exists($request['quid'] , $request->session()->get('basket'))) {
                $mount = $request->session()->get('basket.'.$request['quid'].'.info')[0]['upakovka'];
                if ($request->session()->get('basket.'.$request['quid'].'.mount')[0] >= $mount ) {
                    $count = $request->session()->pull('basket.'.$request['quid'].'.mount')[0];
                    if ($count - $mount >= $mount) {
                        $count = $count - $mount;
                    }
                    $request->session()->push('basket.'.$request['quid'].'.mount', $count);
                }
            }

        session()->save();
            
        return redirect()->back();
    }
  
    //Удаляет товар из корзины
    public function destroy(Request $request)
    {
          
        if (array_key_exists($request['quid'] , $request->session()->get('basket'))) {
            $part = $request->session()->pull('basket');
            unset($part[$request['quid']]);
            $request->session()->put('basket', $part);
        }
        session()->save();
        
        return redirect()->back();
        
    }

    public function movement() {
        $api = new Api;
        $lists = $api->orders_list();
        if (Session::has('user_id')) {
            $orders = Order::where('user_id', Session::get('user_id'))->with('parts')->orderBy('id', 'desc')->get();
        } else {
            $orders = Order::where('user_id', Auth::id())->with('parts')->orderBy('id', 'desc')->get();
        }
        
        foreach ($orders as $order) {
            foreach($order->parts as $part) {
                if (array_key_exists($part->key, $lists)) {
                    if($part->status != $lists[$part->key]) {
                        $part->status = $lists[$part->key];
                        $part->save();
                    }
               }
                
            }
        }

        return Inertia::render('Frontend/Movement', ['data' => $orders]);
    }

    public function change_status ($id, Request $request) {

        $part = Part::find($id);

        if ($request->status == 3 && $request->has('description')) {
            $part->status = $request->description;
        } else {
            $part->status = $request->status;
        }

        $part->save();
        return redirect()->back();

    }

   
}
