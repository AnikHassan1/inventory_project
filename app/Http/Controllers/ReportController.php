<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public  function ReportPages()
    {
      return view('pages.dashboard.report-page');
    }
    public  function SalesReport(Request $request)
    {
      $user_id =$request->header('id');
      $FormDate = date('y-m-d',strtotime($request->FormDate));
      $ToDate = date('y-m-d',strtotime($request->ToDate));

      $total =Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at',"<=",$ToDate)->sum('total');
      $vat =Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at',"<=",$ToDate)->sum('vat');
      $discount = Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at',"<=",$ToDate)->sum('discount');
      $payable = Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at',"<=",$ToDate)->sum('payable');

      $list = Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)
      ->whereDate('created_at',"<=",$ToDate)->with('customer')->get();

      $data =[
        'payable'=>$payable,
        'total'=>$total,
        'vat'=>$vat,
        'discount'=>$discount,
        'list'=>$list,
        'formDate'=>$FormDate,
        'ToDate'=>$ToDate
      ];

      $pdf = Pdf::loadView('report.SalesReport',$data);

      return $pdf->download('invoice.pdf');

    }
}
