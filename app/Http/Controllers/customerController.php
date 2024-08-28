<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class customerController extends Controller
{
    //customer page
    function customerPages(){
        return view('pages.dashboard.customer-page');
    }
    function customerList(Request $request){
             $user_id = $request->header('id');
             return customer::where('user_id',$user_id)->get();
    }
    function customerCreate(Request $request){
             $user_id = $request->header('id');
             return customer::create([
                 "name"=>$request->input('name'),
                 "email"=>$request->input('email'),
                 "mobile"=>$request->input('mobile'),
                 "user_id"=>$user_id
             ]);
    }
    function customerDelete(Request $request){
        $customer_id = $request->input('id');
        $user_id = $request->header('id');
        return customer::where('id',$customer_id)->where('id',$user_id)->delete();
    }

    function customerById(Request $request){
        $customer_id = $request->input('id');
        $user_id = $request->header('id');
        return customer::where('id',$customer_id)->where('id',$user_id)->first();
    }

    function customerupdate(Request $request){
        $customer_id = $request->input('id');
        $user_id = $request->header('id');
        return customer::where('id',$customer_id)->where('id',$user_id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile')
        ]);
    }

}
