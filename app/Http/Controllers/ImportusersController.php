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

        /*Reading File Datas*/
				foreach ($data as $value) {
          /*Explode & serialize demographic_data*/
          $explode_data=explode('|',$value->demographic_data);
          $data=array();
          foreach ($explode_data as  $result) {
              $values=explode(':',$result);
              $data[$values[0]]=$values[1];
          }
          $serialized_data=serialize($data);

          /*All values Combined to single array*/
					$insert[] = ['fname' => $value->first_name, 'lname' => $value->last_name, 'email' => $value->email,'demographic_data'=>$serialized_data];
				}
				if(!empty($insert)){
          /*Insert datas into Database*/
					DB::table('users')->insert($insert);
				}
			}
		}
		return redirect()->action('AddusersController@index');
	}
}
