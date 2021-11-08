<?php

namespace App\Console\Commands;
use App\User;
use Carbon\Carbon; 
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\RemainderEmailDigest;
use App\Mail\FiveDaysExtends;

use Illuminate\Console\Command;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remainder:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Your subcription will end with in 5 days';

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
        
        $users = User::where('has_subscribed',1)->get();
        // dd($users);
       
        // dd($users);
        $datas=[];
        foreach ($users as $user) {
            $datas[$user->id][] = $user->toArray();
        }
        // dd($datas);
        foreach ($datas as $userid=> $users) {
            // dd($users);
            $this->sendEmailToUser($userid,$users);
        }
        // $current = Carbon::now();
        
        // $trialExpires = Carbon::parse($current);
    }


    private function sendEmailToUser($userid,$users){
        $user = User::find($userid);
        $end_time = $user->sub_end;
        // $datetimeFormat = 'Y-m-d';
        // $date = new \DateTime();
        // $time=$date->format($datetimeFormat);
        $current = Carbon::now();
        $extendsfivedays = Carbon::parse($end_time)->addDays(5);
        $expirydate = Carbon::parse($end_time)->subDays(5);
        // $end_date= $end_time->subDay(5);
        if($current === $expirydate){
            Mail::to($user)->send(new RemainderEmailDigest($users));
        }elseif($current === $extendsfivedays){
            Mail::to($user)->send(new FiveDaysExtends($users));
        }else{
            Mail::to($user)->send(new RemainderEmailDigest($users));
        }
        // dd($current);

    }
}
