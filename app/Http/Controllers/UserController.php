<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Skidki;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $skidki = Skidki::all();
        return Inertia::render('Frontend/Users', ['data' => $users, 'skidki' => $skidki]);
    }

    public function personal()
    {
        $users = User::role('admin')->get();
        return Inertia::render('Frontend/Personal', ['data' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ])->validate();

        $user = new User;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->procent = $request->procent;
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->admin) {
            $user->assignRole('admin');
        }
  
        return redirect()->back()
                    ->with('message', 'Пользователь добавлен успешно.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', Rule::unique('users')->ignore($request->id)],
        ])->validate();


        if ($request->has('id')) {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->procent = $request->procent;
            if ($request->password != null) {
                $user->password = Hash::make($request->password);
            }
            if ($request->admin != null && $request->admin != false) {
                $user->assignRole('admin');
            } else {
                $user->removeRole('admin');
            }
            $user->save();
            return redirect()->back()
                    ->with('message', 'Пользователь изменен.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            User::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }

    public function verification(Request $request)
    {
        $user = Auth::user();
        $codeid = $request->codeid;
        if ($user->verificationnumber != null) {
            if ($user->verificationnumber == $codeid) {
                return redirect()->away($user->verificationurl);
            } else {
                return back()->with('message', 'Неверный код');
            }
        } else if ($request->session()->has('verificationnumber')) {
            if ($request->session()->get('verificationnumber') == $codeid) {
                return redirect()->away($request->session()->get('verificationUrl'));
            } else {
                return back()->with('message', 'Неверный код');
            }
        } else {
            $request->user()->sendEmailVerificationNotification();

            return back()->with('message', 'Срок действия кода истек! Повторно отправлен код подтверждения.');
        }

    }
}
