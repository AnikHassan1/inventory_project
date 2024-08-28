<?php

namespace App\helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;



class JWTtoken
{
 public static function createToken($userEmail,$userId){
       $key=env('JWT_KEY');
       $playload =[
        'iss'=>'laravel-token',
        'iat'=>time(),
        'exp'=>time()+60*60,
        'userEmail'=>$userEmail,
        'userId'=>$userId
       ];
      return JWT::encode($playload,$key,'HS256');

    }
    public static function createTokenForSetPassword($userEmail){
      $key = env('JWT_KEY');
      $playload=[
        'iss'=>"laravel-token",
        'iat'=>time(),
        'exp'=>time()+60*60,
        'userEmail'=>$userEmail,
        'userId'=>'0'
      ];
      return JWT::encode($playload,$key,'HS256');
    }

    public static function verifyToken($token){

   try{
       if($token ==null){
        return "unauthorized";
       }else{
        $key =env('JWT_KEY');
        $decode =JWT::decode($token,new Key($key,'HS256'));
        return $decode;
       }
   

   }
   catch(Exception $e){
    return "unauthorized";
   }

    }
}