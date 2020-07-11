<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use App\User;
use App\Mail\NewArrivals;

class MessageController extends Controller
{
    public function getUsers(){

        return User::all();
    }

    public function getMessages(){

        return Message::orderBy('created_at', 'desc')->get();
    }


}
