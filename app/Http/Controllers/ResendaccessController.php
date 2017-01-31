<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\DB;
use Mail;
class ResendaccessController extends Controller
{
    public function ResendAccess(Request $request)
    {
      $user_id=$request->get('user_id');
      $user_email=DB::table('users')->select('email','password')->where('id',$user_id)->get();

      $length=8;
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$^&*()_+";
			$password = substr( str_shuffle( $chars ), 0, $length );
      $hash_password = Hash::make($password);

      DB::table('users')->where('id',$user_id)->update(['password'=>$hash_password]);

      foreach ($user_email as  $value) {
      $message="Your Email is : ".$value->email ."<br> Your password is : ".$password;
      $data = array('subject'=>'Login Details', 'from' => 'dhinesh@authorselvi.com', 'from_name' => 'Kumar','message'=>$message,'E_title'=>'Your Login Details','email'=>$value->email);
				$mail=Mail::send([], $data, function($message) use ($data) {
				$message->from('dhinesh@authorselvi.com', $data['E_title']);
				$message->to($data['email']);
				$message->subject($data['subject'])
				->setBody($data['message'], 'text/html');
			});
      }
      return redirect()->action('AddusersController@index');
    }
}
