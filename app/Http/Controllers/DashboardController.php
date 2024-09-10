<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use App\Models\customer;
use App\Models\Invoice;
use App\Models\product;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    function DashboardPage():View{
        return view('pages.dashboard.dashboard-page');
    }
    // summary
    function summary(Request $request){
        $user_id =$request->header('id');

        $product = product::where('user_id',$user_id)->count();
        $category = categorie::where('user_id',$user_id)->count();
        $customer = customer::where('user_id',$user_id)->count();
        $invoice = Invoice::where('user_id',$user_id)->count();

        $total = Invoice::where('user_id',$user_id)->sum('total');
        $vat = Invoice::where('user_id',$user_id)->sum('vat');
        $payable = Invoice::where('user_id',$user_id)->sum('payable');

        return [
           'product'=>$product,
           'category'=>$category,
           'customer'=>$customer,
           'invoice'=>$invoice,

           'total'=>round($total,2),
           'vat'=>round($vat,2),
           'payable'=>round($payable,2),
        ];
    }
}
