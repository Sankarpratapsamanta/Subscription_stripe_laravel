<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Plan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

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
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function watch()
    {
        $user = Auth::user();
        $end_time = $user->sub_end;
        // return $user;
        $current = Carbon::now();
        $extendsfivedays = Carbon::parse($end_time)->addDays(5);
        // return $extendsfivedays;
        $joined = $user->joined_at;
        $trialExpires = Carbon::parse($joined)->addDays(14);
        if($current > $trialExpires){
            return redirect('/package');
        }elseif($user->has_subscribed === 1){
            return view('watch.index');
        }elseif($current > $extendsfivedays){
            $user->delete();
        }else{
            return view('watch.index');
        }
    }

    public function plan()
    {
        $plans = Plan::all();
        $user = auth()->user();
        // return $user;
        return view('userplans.index',compact('plans','user'));
    }

    
}

