<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Diapazon;
use Illuminate\Support\Facades\Validator;

  
class DiapazonController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Diapazon::all();
        return Inertia::render('Frontend/Diapazon', ['data' => $data]);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'from_price' => ['required'],
            'to_price' => ['required'],
            'procent' => ['required'],
        ])->validate();
  
        Diapazon::create($request->all());
  
        return redirect()->back()
                    ->with('message', 'Диапазон наценок создан успешно.');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'from_price' => ['required'],
            'to_price' => ['required'],
            'procent' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            Diapazon::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Диапазон наценок изменен успешно.');
        }
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Diapazon::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
