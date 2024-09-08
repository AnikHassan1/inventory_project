<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
  public  function InvoicePages()
  {
    return view('pages.dashboard.invoice-page');
  }
  public  function SalesPages()
  {
    return view('pages.dashboard.sale-page');
  }

  //   invoiceCreate
  public function InvoiceCreate(Request $request)
  {
    DB::beginTransaction();
    try {
      $user_id = $request->header('id');
      $user_email = $request->header('email');

      $total = $request->input('total');
      $discount = $request->input('discount');
      $vat = $request->input('vat');
      $payable = $request->input('payable');
      $customer_id = $request->input('customer_id');

      $invoice = Invoice::crete([
        'total' => $total,
        'discount' => $discount,
        'vat' => $vat,
        'payable' => $payable,
        'user_id' => $user_id,
        'customer_id' => $customer_id
      ]);

      $invoice_id = $invoice->id;

      $products = $request->input('products');

      foreach ($products as $eachProducts) {
        InvoiceProduct::create([
          "Invoice_id" => $invoice_id,
          "user_id" => $user_id,
          "product_id" => $eachProducts['product_id'],
          "qty" => $eachProducts['qty'],
          "sales_price" => $eachProducts['sales_price']
        ]);
      }

      DB::commit();
      return 1;
    } catch (Exception $e) {
      DB::rollBack();
      return 0;
    }
  }
  public function InvoiceSelect(Request $request){
    $user_id =$request->header('id');
    return Invoice::where('user_id',$user_id)->with('customer')->get();
  }
  public function InvoiceDetails(Request $request){
    $user_id =$request->header('id');
    $customerDetails  = customer::where('user_id',$user_id)->where('id',$request->input('cus_id'))->first();
    $InvoiceTotal     = Invoice::where('user_id',$user_id)->where('id',$request->input('Invoice_id'))->first();
    $Invoiceproduct   = InvoiceProduct::where('Invoice_id',$request->input('Inv_id'))
                      ->where('user_id',$user_id)->get();

    return array(
      'customer'=>$customerDetails,
      'invoice'=>$InvoiceTotal,
      'product'=>$Invoiceproduct
    );              
  }
  public function InvoiceDelete(Request $request){
    DB::beginTransaction();
    try{
      $user_id =$request->header('id');
      InvoiceProduct::where('user_id',$user_id)
              ->where('id',$request->input('Inv_id'))
              ->delete();
      Invoice::where('id',$request->input('Inv_id'))->delete();
      DB::commit();
      return 1;        
    }catch(Exception $e){
       DB::rollBack();
       return 0;
    }
    
  }
}
