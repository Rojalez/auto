<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Postavshiki;
use Illuminate\Support\Facades\Validator;

  
class PostavshikiController extends Controller
{

    public function index()
    {
        $data = Postavshiki::all();
        return Inertia::render('Frontend/Postavshiki', ['data' => $data]);
    }

    public function change_status($status, $id)
    {
        $postavshik = Postavshiki::find($id);
        if ($status == 'on') {
            $postavshik->status = 'Включен';
        } else {
            $postavshik->status = 'Выключен';
        }
        $postavshik->save();
        
        return redirect()->back();
    }
 
}
