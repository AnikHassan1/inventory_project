<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use Exception;
use Illuminate\Http\Request;

class categoriesController extends Controller
{
    //categories page
    function CategoriesPage(){
        return view('pages.dashboard.category-page');
    }

    function categoriesList(Request $request){
        $user_id = $request->header('id');
        return categorie::where('user_id',$user_id)->get();
    }

    function categoriesCreate(Request $request){
        $user_id = $request->header('id');
        return categorie::create([
        'name'=>$request->input('name'),
        'user_id'=>$user_id
        ]);
    }
    function categoriesDelet(Request $request){
          $user_id=$request->header('id');
          $category_id=$request->input('id');
          return categorie::where('id',$category_id)->where('user_id',$user_id)
          ->delete();
    }   
    function categoriesID(Request $request){
          $user_id=$request->header('id');
          $category_id=$request->input('id');
          return categorie::where('id',$category_id)->where('user_id',$user_id)
          ->first();
    }   
    function categoriesUpdate(Request $request){
            $user_id=$request->header('id');
            $category_id=$request->input('id');
            return categorie::where('id',$category_id)->where('user_id',$user_id)
            ->update([
              'name'=>$request->input('name')
            ]);
    }   

    }

