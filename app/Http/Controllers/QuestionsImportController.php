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
          $i=2;

          foreach ($data as $key=>$result) {
            if(isset($result["survey_id"]) && isset($result["question_text"]) && isset($result["question_type"]) && isset($result["question_required"]) && isset($result["question_enabled"]) && isset($result["question_dimension"]) && isset($result["display_order"]) && isset($result["options"])
            && isset($result["option_weight"])){

              /*Check Survey id*/
              $survey_id=DB::table('surverys')->select('id')->where('id',$result->survey_id)->get();

              $welcome_count = DB::table('questions')
              ->select('question_type')
              ->where('survey_id','=',$result->survey_id)
              ->where('question_type','welcome_text')
              ->get();

              $thank_count = DB::table('questions')
              ->select('question_type')
              ->where('survey_id','=',$result->survey_id)
              ->where('question_type','thankyou_text')
              ->get();


              $op_symbol_count=substr_count($result->options,'|');
              $op_weight_symbol_count=substr_count($result->option_weight,'|');

              if ($result->survey_id=="") {
                $error[]="Survey id column is Empty Plz check your uploaded sheet line@ $i ";
              }
              elseif ($result->question_text=="") {
                $error[]="Question Column is Empty plz enter question line@ $i";
              }
              elseif ($result->question_type=="") {
                $error[]="Question type Column is Empty. plz enter question type line@ $i";
              }
              elseif ($result->question_required=="") {
                $error[]="question_required Column is Empty line@ $i";
              }
               elseif (count($survey_id)=='0') {
                  $error[]="Survey id is not valid Please check your survey table and survey_id column in Spreed Sheet line @ $i";
              }
              elseif ($result->question_dimension=="") {
                $error[]="Question dimension Column is Empty line@ $i";
              }
              elseif ($result->question_enabled=="") {
                $error[]="Question enabled Column is Empty line@ $i";
              }
                elseif (($result->question_type=="welcome_text") && ($welcome_count!="0")) {
                  echo $message[]="Welcome text Already enterd for this survey  $result->survey_id line@ $i";

                }
                // elseif (($result->question_type=="thankyou_text") && ($thank_message=="thankyou_text")) {
                //   $message[]="Thank you text Already enterd for this survey  $result->survey_id ";
                //
                // }
                elseif ($result->question_type!="text" && $result->question_type!="textarea" && $result->question_type!="radio" && $result->question_type!="dropdown" && $result->question_type!="checkbox" && $result->question_type!="welcome_text" && $result->question_type!="thankyou_text") {
                  $error[]="Plz enter valid question type. Only you can use for this options text,textarea,radio,dropdown,checkbox,welcome_text,thankyou_text. line@ $i";
                }
                elseif ($result->question_type=='text' && $result->options!= 'Null') {
                  $error[]="You are question_type select in 'text' Please enter option  to null. line@ $i";
                }
                elseif ($result->question_type=='text' && $result->option_weight!= "0") {
                  $error[]="You are question_type select in 'text' Please enter option_weight to 0. line@ $i";
                }
                elseif ($result->question_type=='textarea' && $result->options!='Null') {
                  $error[]="You are select in 'textarea' Please enter option  to null. line@ $i";
                }
                elseif ($result->question_type=='textarea' && $result->option_weight!= "0") {
                  $error[]="You are select in 'text' Please enter option_weight to 0. line@ $i";
                }
                elseif ($result->question_type!='textarea' && $result->option== 'Null') {
                  $error[]="Plz enter Options don't enter to Null. line@ $i";
                }
                elseif ($result->question_type!='text' && $result->option== 'Null') {
                  $error[]="Plz enter Options don't enter to Null. line@ $i";
                }
                elseif ($op_symbol_count!=$op_weight_symbol_count) {
                  $error[]="Option and option_weight ( $result->options  and  $result->option_weight ) is not Equal. line@ $i";
                }
                else {
                  $message='Sucessfull datas imported.';
              }
            }
            else {
              $error="Header Mismatch line@ 1. (survey_id, question_text, question_type, question_required, question_enabled, question_dimension, display_order, options, option_weight) Plz enter this format.";
            }
            $i++;
          }
        }
      }
      if(isset($error))
      {
        $mess=$error;
      }
      else {

        // foreach ($data as $key=>$result) {
        //   if ($result->question_required=="Yes" || $result->question_enabled=="Yes") {
        //     $required_enable='0';
        //   }
        //   else {
        //     $required_enable='1';
        //   }
        //   $lastinsert_id=DB::table('questions')->insertGetId(['survey_id'=>$result->survey_id,'question_text'=>$result->question_text,'question_type'=>$result->question_type,'question_required'=>$required_enable,'question_enabled'=>$required_enable,'question_dimension'=>$result->question_dimension,'display_order'=>$result->display_order]);
        //   $option=explode('|',$result->options);
        //
        //   $option_weight=explode('|',$result->option_weight);
        //   $arrays_combine=array_combine($option,$option_weight);
        //   foreach($arrays_combine as $key=>$value)
        //   {
        //       DB::table('options')->insert(['option_text'=>$key,'option_weight'=>$value,'question_id'=>$lastinsert_id]);
        //   }
        // }
        $mess=$message;

      }
      session()->flash('msg', $mess);
      // return redirect()->back();
    }
}
