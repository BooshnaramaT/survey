<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Crypt;
use Illuminate\Support\Facades\DB;
use Mail;
class ResendaccessController extends Controller
{
    public function ResendAccess(Request $request)
    {
      $user_id=$request->get('user_id');
      $decrypt_pass=DB::table('users')->select('email','password')->where('id',$user_id)->get();

       $encryptedPassword = encrypt('Test');
       $decryptedPassword = decrypt($encryptedPassword);


      foreach ($decrypt_pass as  $value) {
      // echo decrypt($value->password);

      $message="Your Email is : ".$value->email ."<br> Your password is : ".Crypt::decrypt($value->password);
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
