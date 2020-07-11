<?php

namespace App\Console\Commands;


use DateTime;
use Illuminate\Console\Command;

use App\Message;
use Carbon\Carbon;
use App\Jobs\SendMailJob;
use App\User;
use App\Mail\NewArrivals;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = date("Y-m-d H:i");
        logger($now);

        $messages = Message::get();
        if($messages !== null){
            //Get all messages that their dispatch date is due
            $messages->where('date_string','<=', $now)->each(function($message) {
                if($message->delivered == 'NO')
                {
                    // Find user by message id
                    $user = User::find($message->user_id);

                    // Check if weather data avaible
                    if (Cache::has(date("Y-m-d").$user->city)) {

                        //Chechk weather data from cache
                        $message->body = Cache::get(date("Y-m-d").$user->city);

                        dispatch(new SendMailJob(
                                $user->email,
                                new NewArrivals($user,$message ))
                        );

                        $message->delivered = 'YES';
                        $message->save();

                        // Create new message for tomorrow
                        $newMessage = new Message();
                        $datetime = new DateTime('tomorrow');
                        $newMessage->title = $datetime->format('Y-m-d')." Weather report";
                        $newMessage->body = "";
                        $newMessage->user_id = $user->id;
                        $newMessage->date_string = strtotime('+1 day', strtotime($user->email_time));
                        $newMessage->save();
                    }else{
                        //Make request to weather api
                        $response = Http::get('http://api.openweathermap.org/data/2.5/weather?q='.$user->city.'&APPID='.env("WEATHER_API"));
                        //Store weather data 2 days
                        Cache::put(date("Y-m-d").$user->city,$response,60*60*24*2);
                    }

                }
            });
            logger("No messsage found2");
        }else{
            logger("No messsage found");
        }
    }
}
