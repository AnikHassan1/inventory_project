<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;



use App\Mail\otpMail;
use Firebase\JWT\JWT;
use App\helper\JWTtoken;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
  function LoginPage(): View
  {
    return view('pages.auth.login-page');
  }

  function RegistrationPage(): View
  {
    return view('pages.auth.registration-page');
  }
  function SendOtpPage(): View
  {
    return view('pages.auth.send-otp-page');
  }
  function VerifyOTPPage(): View
  {
    return view('pages.auth.verify-otp-page');
  }

  function ResetPasswordPage(): View
  {
    return view('pages.auth.reset-pass-page');
  }

  function ProfilePage(): View
  {
    return view('pages.dashboard.profile-page');
  }


  function userRegistration(Request $request)
  {
    // $validated = $request->validate([
    //     'fastname' => 'required|max:255',
    //     'lastname' => 'required|max:255',
    //     'email' => 'required|unique:users|max:255',
    //     'password' => 'max:55',
    //     'mobile' => 'max:55',

    // ]);

    try {

      User::create([
        'fastname' => $request->input('fastname'),
        'lastname' => $request->input('lastname'),
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'mobile' => $request->input('mobile'),
      ]);
      return response()->json([
        'status' => "success",
        'message' => "user Registration success"
      ], status: 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => "failed",
        'message' => $e->getMessage()
      ], 401);
    }
  }

  function userLogin(Request $request)
  {
    $count =  User::where('email', '=', $request->input('email'))
      ->where('password', '=', $request->input('password'))
      ->select('id')->first();
    if ($count !== null) {
      $token = JWTtoken::createToken($request->input('email'), $count->id);
      return response()->json([
        'status' => "success",
        'message' => "login successfully",

      ], 200)->cookie('token', $token, 60 * 24 * 30, '/');
    } else {
      return response()->json([
        'status' => "failed",
        'message' => "unauthorized"
      ], 401);
    }
  }
  function sendOtpCode(Request $request)
  {
    $email = $request->input("email");
    $otp = rand(1000, 9999);
    $count = User::where('email', '=', $email)->count();

    if ($count == 1) {
      // send otp
      // insert code table
      Mail::to($email)->send(new otpMail($otp));
      User::where('email', '=', $email)->update(['otp' => $otp]);
      return response()->json([
        "status" => "success",
        "message" => "4 digit otp send your Gmail"
      ], 200);
    } else {
      return response()->json([
        "status" => "failed",
        "message" => "unauthorized"
      ], 401);
    }
  }
  function verifyOtpCode(Request $request)
  {
    $email = $request->input('email');
    $otp = $request->input('otp');
    $count = User::where('email', '=', $email)
      ->where('otp', '=', $otp)->count();

    if ($count == 1) {
      // Database update 
      User::where('email', '=', $email)->update(['otp' => '0']);
      // pass Reset Token Issue
      $token = JWTtoken::createTokenForSetPassword($request->input('email'));
      return response()->json([
        "status" => "success",
        "message" => "verify Otp Success",
        "token" => $token
      ])->cookie('token', $token, 60 * 5);
    } else {
      return response()->json([
        "status" => "failed",
        "message" => "unauthorized"
      ], 401);
    }
  }

  function   passwordReset(Request $request)
  {
    try {
      $email = $request->header('email');
      $password = $request->input('password');

      $user = User::where('email', $email)->first();
      // return [$email, $password];
      // User::where('email',$email)->update(['password',$password]);
      $user->password = $password;
      $user->save();
      return response()->json([
        "status" => "success",
        "message" => "Reset Password Success"
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        "status" => "failed",
        "message" => $e->getMessage()
      ], 401);
    }
  }

  function userlogout()
  {
    return redirect('/userlogin')->cookie('token', '', -1);
  }
  function profileForm(Request $request)
  {
    $email = $request->header('email');
    $user = User::where('email', '=', $email)->first();
    return response()->json([
      "status" => "success",
      "message" => "Request Success",
      "data" => $user
    ],200);
  }
  function userProfileUpdate(Request $request)
  {
    try{
    $email =$request->header('email');
    $fastname =$request->input('fastname');
    $lastname =$request->input('lastname');
    $mobile =$request->input('mobile');
    $password =$request->input('password');
    User::where('email','=',$email)->update([
        "fastname" =>$fastname,
        "lastname" =>$lastname,
        "mobile" =>$mobile,
        "password" =>$password,
    ]);
    return response()->json([
      "status" => "success",
      "message" => "Request Success"
    ],200);
    }catch(Exception $e){
      return response()->json([
        "status" => "success",
        "message" => "Somethings Is Wrong"
      ],401);
    }
  }
}
