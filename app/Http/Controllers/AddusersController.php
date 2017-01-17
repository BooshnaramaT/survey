<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\addusers;
use Illuminate\Support\Facades\DB;
class AddusersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*Getting All values form Database*/
         $data = addusers::all();
         $datas = addusers::paginate(2);

        return View('admin.userindex', compact('datas'))->with('i', ($request->input('name', 1) - 1) * 5);;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      /*validation for Input fields*/

      $this->validate($request, [
        'email'  => 'Required|Between:3,64|email|Unique:users',
    ]);

        /* Getting values From Input fields*/
        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $email=$request->input('email');


        $demographic_data=$request->input('demographic_data');
        /* Getting demographic data values from input field and split value(key & vakue) from array */
        $data=array();
        foreach ($demographic_data as $value) {
          $values=explode(':',$value);
          $data[$values[0]]=$values[1];
        }

        $serialized_data=serialize($data);

        /*Insert values in to Database*/
        $datas = new addusers;
        $datas->fname=$fname;
        $datas->lname=$lname;
        $datas->email=$email;
        $datas->demographic_data=$serialized_data;
        $datas->save();

        return redirect()->action('AddusersController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $user = addusers::find($id);

      return view('admin.edit_users', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      /* Getting values From Input fields*/
      $first_name=$request->input('fname');
      $last_name=$request->input('lname');
      $email=$request->input('email');

      /* Getting demographic data values from input field and split value(key & value) from array */
      $demographic_data=$request->input('demographic_data');
      $data=array();
      foreach ($demographic_data as $value) {
        $values=explode(':',$value);
        $data[$values[0]]=$values[1];
      }
      $serialized_data=serialize($data);

      /*Update values into Database*/
      $data= DB::table('users')
				->where('id', $id)
				->update(['fname' => $first_name,'lname'=>$last_name,'email'=>$email,'demographic_data'=>$serialized_data]);
      return redirect()->action('AddusersController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      /*Find and delete particular id from Database*/
      $user = addusers::find($id)->delete();
      /*Redirect to indexcontroller*/
      return redirect()->action('AddusersController@index');
    }
}
