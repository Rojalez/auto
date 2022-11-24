<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Skidki;
use Illuminate\Support\Facades\Validator;

  
class SkidkiController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Skidki::all();
        return Inertia::render('Frontend/Skidki', ['data' => $data]);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'procent' => ['required'],
        ])->validate();
  
        Skidki::create($request->all());
  
        return redirect()->back()
                    ->with('message', 'Скидка добавлена успешно.');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'procent' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            Skidki::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Скидка изменена успешно.');
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
            Skidki::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
