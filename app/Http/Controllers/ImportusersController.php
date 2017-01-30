<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;

class ImportusersController extends Controller
{
    public function importExcel()
	{
    /*Get input File*/
		if(Input::hasFile('import_file')){
			$path = Input::file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
        $results = $reader->all();
			})->get();


			if(!empty($data) && $data->count()){

        $i=1;
        $message=array();
				foreach ($data as $value) {
          if(isset($value['first_name']) && isset($value['last_name']) && isset($value['email']) && isset($value['demographic_data']))
          {
          $datas=DB::table('users')->select('email')->where('email',$value->email)->get();

          if($value->first_name=="")
          {
           $message[]="First name Column is null Or not Found line @ $i";
          }
          elseif ($value->first_name=="first_name") {
            $message[]= "first name is not found";
          }
          elseif ($value->first_name=="") {
            $message[]="First Name Column is Null plz check your spreed sheet line @ $i";
          }
          elseif ($value->email=="") {
            $message[]="Email Column is Null plz check your spreed sheet line @ $i";
          }
          elseif ($value->demographic_data=="") {
            $message[]="Demographic data Column is Null plz check your spreed sheet line @ $i";
          }
          elseif (filter_var($value->email,FILTER_VALIDATE_EMAIL) === false) {
              $message[]= "($value->email) is not a valid email address  line @ $i";
          }
          elseif(count($datas)>=1)
          {
            $message[]="This email id is already exists ($value->email)  line @ $i";
          }
          else
          {
            $explode_data=explode('|',$value->demographic_data);
            $data=array();
            foreach ($explode_data as $result) {
                $values=explode(':',$result);
                $data[$values[0]]=$values[1];
            }
            $serialized_data=serialize($data);

            $insert[] = ['fname' => $value->first_name, 'lname' => $value->last_name, 'email' => $value->email,'demographic_data'=>$serialized_data];
            $message= "Datas imported";
          }
        }
        else {
          $message="Heading Mismatch line @ 1 . (first_name,last_name,email,demographic_data) Plz enter this format.";
        }
        $i++;
				}
        if(isset($insert)){
          /*Insert datas into Database*/
          DB::table('users')->insert($insert);
        }

			}
		}
    session()->flash('msg', $message);
    if($message=="Datas imported")
		{
      return redirect()->action('AddusersController@index');
    }
    else {
      return redirect()->back();
    }
	}
}
