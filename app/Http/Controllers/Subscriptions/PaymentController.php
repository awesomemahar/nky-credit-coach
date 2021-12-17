<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function index()
    {

       $stripe = new StripeClient(env("STRIPE_SECRET"));
       $user = Auth::user();
////        $subscription = $user->subscription('default');
////        $id = $subscription->latestPayment()->id;
//        dd($user->subscription('default'));
//
//        $subscriptions = $stripe->subscriptions->all(['customer' => $user->stripe_id]);
//
//
//
//        dd($subscriptions);
//        dd($user->subscriptions->first()->stripe_id);
//        dd($stripe->subscriptions->cancel($user->subscriptions->first()->stripe_id));
//        $dataActive = $stripe->subscriptions->all(['customer' => $user->stripe_id]);
//        dd($dataActive);
//        dd($user->subscriptions('default')->stripe_plan);
        $data = [
            'intent' => auth()->user()->createSetupIntent()
        ];
        $plans = null;
        if(!is_null($user->stripe_id)){
            $subscriptions = $stripe->subscriptions->all(['customer' => $user->stripe_id]);
        }else{
            $subscriptions = null;
        }

        if(isset($subscriptions->data[0])){
            $current_subscription = $subscriptions->data[0];
            if(isset($current_subscription->plan->id)){
                $current_subscription = $current_subscription->plan->id;
                $currentPlan  = SubscriptionPackage::where('stripe_id',$current_subscription)->first();
                if($currentPlan->package_type == 'Business'){
                    $clients = User::where('business_id', $user->id)->count();
                    $plans = SubscriptionPackage::where('package_type', $currentPlan->package_type)->whereNotNull('stripe_id')->where('no_of_clients','>=', $clients)->get();
                }elseif($currentPlan->package_type == 'Starter'){
                    $plans = SubscriptionPackage::where('package_type', $currentPlan->package_type)->whereNotNull('stripe_id')->get();
                }
            }else{
                if($user->type == 2){
                    $plans = SubscriptionPackage::where('package_type', 'Business')->whereNotNull('stripe_id')->get();
                }elseif($user->type == 3){
                    $plans = SubscriptionPackage::where('package_type', 'Starter')->whereNotNull('stripe_id')->get();
                }
            }
        }else{
            if($user->type == 2){
                $plans = SubscriptionPackage::where('package_type', 'Business')->whereNotNull('stripe_id')->get();
            }elseif($user->type == 3){
                $plans = SubscriptionPackage::where('package_type', 'Starter')->whereNotNull('stripe_id')->get();
            }
        }
       return view('business.subscription.create',compact('plans'))->with($data);;
    }


    public function orderPost(Request $request)
    {
        $user = auth()->user();
        $input = $request->all();
        $token =  $request->stripeToken;
        $paymentMethod = $request->paymentMethod;
        try {

            Stripe::setApiKey(env('STRIPE_SECRET'));

            if (is_null($user->stripe_id)) {
                $stripeCustomer = $user->createAsStripeCustomer();
            }

            \Stripe\Customer::createSource(
                $user->stripe_id,
                ['source' => $token]
            );
            $subscription = $user->newSubscription('default',$input['plan'])
                ->trialDays(7)
                ->create($paymentMethod, [
                    'email' => $user->email,
                ]);

            $package = SubscriptionPackage::where('stripe_id', $subscription->stripe_price)->first();
            $user->subscription_package_id = $package->id;
            $user->subscription_status = 1;
            $user->save();

            if($user->type == 2){
                $message = 'Subscription is completed. For more details, Please  <a href="'. route('business.profile') . '">Click Here</a>';
                return redirect()->route('business.index')->with('success',$message);
            }elseif($user->type == 3){
                $message = 'Subscription is completed. For more details, Please  <a href="'. route('client.profile') . '">Click Here</a>';
                return redirect()->route('client.index')->with('success',$message);
            }
        } catch (Exception $e) {
            return back()->with('success',$e->getMessage());
        }

    }
}
