<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use DateTime;
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
     * @return \Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $user = Auth::user();
        $user->city = $request->city;
        $user->email_time = $request->time;
        $user->save();

        // if user not have any message create
        if ($user->messages()->count() == 0){
            $newMessage = new Message();

            $datetime = new DateTime('tomorrow');

            $newMessage->title = $datetime->format('Y-m-d')." Weather report";
            $newMessage->body = "";
            $newMessage->user_id = $user->id;

            $newMessage->date_string = strtotime('+1 min', strtotime($user->email_time));

            $newMessage->save();
        }
        return redirect('home');
    }
}
