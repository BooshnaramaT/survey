<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;

class QuestionsImportController extends Controller
{
    public function importQuestion()
    {
        return view('admin.quesform');
    }
    public function stoteQuestions()
    {
      if(Input::hasFile('import_file')){
        $path = Input::file('import_file')->getRealPath();
        $data = Excel::load($path, function($reader) {
          $results = $reader->all();
        })->get();

        if(!empty($data) && $data->count()){

          foreach ($data as $result) {

            $data=DB::table('questions')->insert(['survey_id'=>$result->survey_id,'question_text'=>$result->question_text,'question_type'=>$result->question_type,'question_required'=>$result->question_required,'question_enabled'=>$result->question_enabled,'question_dimension'=>$result->question_dimension,'display_order'=>$result->display_order]);
            $lastinsert_id=DB::table('questions')->max('id');

            $option=explode('|',$result->options);
            $option_weight=explode('|',$result->option_weight);
            $arrays_combine=array_combine($option,$option_weight);
            foreach($arrays_combine as $key=>$value)
            {
                DB::table('options')->insert(['option_text'=>$key,'option_weight'=>$value,'question_id'=>$lastinsert_id]);
            }
          }

        }
      }
      Session::flash('message', $message);
      return Redirect::back();
    }
}
