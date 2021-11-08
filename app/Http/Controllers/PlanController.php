<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use App\Plan;
use Stripe\Stripe;
// use Stripe;
use Illuminate\Support\Facades\Auth;
use App\User;
use Laravel\Cashier\Cashier;
use Stripe\StripeClient;

class PlanController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $plans = Plan::all();
        
        return view('admin.plans.index',compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

        $data = $request->except('_token');


        $data['slug'] = strtolower($data['plan_name']);
        $price = $data['price'] *100;   

        $stripe = \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
      
        
        $product = \Stripe\Product::create([
            'name' => $data['plan_name'],
        ]);
        $interval=null;
        if($data['duration'] === '30'){
            $interval = 'month';
        }elseif($data['duration'] === '365'){
            $interval = 'year';
        }elseif($data['duration'] === '1'){
            $interval = 'day';
        }


        $stripePlanCreation = \Stripe\Plan::create([
            'amount' => $price,
            'currency' => 'inr',
            'interval' => $interval, //  it can be day,week,month or year
            'product' => $product->id,
        ]);

        $data['stripe_plan'] = $stripePlanCreation->interval;
        $data['stripe_id'] = $stripePlanCreation->id;
        $data['product_id'] = $stripePlanCreation->product;


        Plan::create($data);



        return redirect('/admin/plans');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
       
        $plan= Plan::where('slug',$id)->first();

        $intent = auth()->user()->createSetupIntent();

        
        
        return view('userplans.show', compact('plan', 'intent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan= Plan::find($id);
        return view('admin.plans.edit',compact('plan'));
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
        $exitplan= Plan::find($id);

        Stripe::setApiKey(config('services.stripe.secret'));

   

        $plan = \Stripe\Plan::retrieve($exitplan->stripe_id); 
        $price = $request->price *100; 

        if($request->duration === '30'){
            $interval = 'month';
        }elseif($request->duration === '365'){
            $interval = 'year';
        }elseif($request->duration === '1'){
            $interval = 'day';
        }
    

        $stripePlanCreation = \Stripe\Plan::create([
            'amount' => $price,
            'currency' => 'inr',
            'interval' => $interval, //  it can be day,week,month or year
            'product' => $plan->product,
        ]);
       
        $exitplan->price =  $request->price;
        $exitplan->stripe_id = $stripePlanCreation->id;
        $exitplan->duration = $request->duration;
        $exitplan->save();
      
        return redirect('/admin/plans')->with('success' , 'Plan update successfully !');
        
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

    public function customerPlan(Request $request)
    {   

            Stripe::setApiKey(config('services.stripe.secret'));
            $authuser =Auth::user();
            $user = $request->user();
            $plan = Plan::where('slug',$request->plan)->first(); 
            $method = $request->input('payment_method');
            $paymentMethod = \Stripe\PaymentMethod::retrieve($method);

        try{
            $customer = \Stripe\Customer::create([
                'email' => $user->email, // A field from my previously registered laravel user
            ]);
            
            
            $paymentMethod->attach([
                'customer' => $customer->id,
            ]);
            
            $customer = \Stripe\Customer::update($customer->id,[
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod->id,
                ],
            ]);
            
            $subscription = \Stripe\Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    [
                        'plan' => $plan->stripe_id,
                    ],
                ],
                
                'off_session' => TRUE, //for use when the subscription renews
            ]);

            // return $subscription;
            $sub_date= $subscription->current_period_start;
            $sub_end = $subscription->current_period_end;

            
            $datetimeFormat = 'Y-m-d';
            $date = new \DateTime();
           
            $date->setTimestamp($sub_date);
            $start_date= $date->format($datetimeFormat);
            $date->setTimestamp($sub_end);
            $end_date= $date->format($datetimeFormat);
          

            $user->update([
                'plan_id' => $request->plan_id,
                'has_subscribed' => 1,
                'line1' => $request->line1,
                'line2' => $request->line2,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'stripe_status' => $subscription->status,
                'plan' => $request->plan,
                'card_brand' => $paymentMethod->card->brand,
                'card_last_four' => $paymentMethod->card->last4,
                'subscription_id' => $subscription->id,
                'stripe_id'=>$customer->id,
                'sub_start'=>$start_date,
                'sub_end'=>$end_date
            ]);
            return redirect('/plans')->with('success' , 'Thank you for subscribing !');
    
            } catch (\Throwable $err) {
                return response()->json($err);
            }
    }

    public function cancelsubscription()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $authuser =Auth::user();

        try {
            $subscription = \Stripe\Subscription::retrieve($authuser->subscription_id);       
            $subscription->cancel();
            $authuser->update([
                'plan_id'=>null,
                'has_subscribed' => null,
                'plan'=>null,
                'stripe_status' => $subscription->status,
                'subscription_id' => null,
                'sub_start'=>null,
                'sub_end'=>null
            ]);
            return redirect('/plans')->with('success' , 'Subscription canceled successfully');
        } catch (\Throwable $err) {
            return response()->json($err);
        }
        

    }
}
