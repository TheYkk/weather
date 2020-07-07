<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Save user city
     *
     * @param Request $request
     */
    public function save(Request $request)
    {
        $user = Auth::user();
        $user->city = $request->city;

        $user->save();

        return redirect('home');
    }
}
