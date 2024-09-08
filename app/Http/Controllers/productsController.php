<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class productsController extends Controller
{
    function productPages(){
        return view('pages.dashboard.product-page');
    }
    //
    function productsList(Request $request)
    {
        $user_id = $request->header('id');
        return product::where('user_id', $user_id)->get();
    }
    function productCreate(Request $request)
    {
        $user_id = $request->header('id');
        // img upload
        $img = $request->file('img');
        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}.{$t}.{$file_name}";
        $img_url = "uploads/{$img_name}";
        $img->move(public_path('uploads'), $img_name);


        return product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img' => $img_url,
            'category_id' => $request->input('category_id'),
            'user_id' => $user_id
        ]);
    }
    function productUpdate(Request $request)
    {
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        
        // check file
        if ($request->hasFile('img')) {


            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}.{$t}.{$file_name}";
            $img_url = "uploads/{$img_name}";
            $img->move(public_path('uploads'), $img_name);
           
            //delete file
      
            $filePath = $request->input('file_path');
            File::delete($filePath);
            
            return product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img' => $img_url,
                'category_id' => $request->input('category_id')
            ]);
        } else {
            return product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'category_id' => $request->input('category_id')
            ]);
        }
    }
    function productByID(Request $request)
    {
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        return product::where('id', $product_id)->where('user_id', $user_id)->first();
    }
    function productDelet(Request $request)
    {
        $user_id = $request->header('id');

        $product_id = $request->input('id');
        $filePath = $request->input('file_path');

       
            File::delete($filePath);
      

        // Step 3: Delete the record from the database
      


        return product::where('id', $product_id)->where('user_id', $user_id)->delete();
    }
   
}
