@extends('layouts.header')
<title>Edit user section @yield('title')</title>
<div class="container">
  <div class="col-sm-8 col-sm-offset-2 well">
    <h1>Edit Participants</h1>
      {!! Form::model($user, ['method' => 'PATCH', 'action' => ['AddusersController@update', $user->id],'name'=>'example2','id'=>'surveyForm']) !!}
      <div class="form-group">
           <input type="text" class="form-control" placeholder="First Name"name="fname" value="{{$user->fname}}"/>
      </div>
      <div class="form-group">
           <input type="text" class="form-control" name="lname" placeholder="Last Name" value="{{$user->lname}}"/>
      </div>
   <div class="form-group">
           <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{$user->email}}"/>
   </div>
   <?php $datas=unserialize($user->demographic_data); ?>
   <?php $s_no=1; ?>
@foreach($datas as $key=>$value)
   <div class="form-group">
       <div class="field_wrapper">
         <input type="text" class="form-control customhandler" name="demographic_data[]" placeholder="Others" value="{{$key}}:{{$value}}"/>
         @if($s_no==1)
         <a href="javascript:void(0);" class="addButton" title="Add field"><img src="/images/1484060710_plus.png" alt="" /></a>
         @elseif($s_no!=1)
         <a href="javascript:void(0);" class="removeButton" title="Add field"><img src="/images/1484060813_minus.png" alt="" /></a>
         @endif
       </div>
 </div>
 <?php $s_no++; ?>
 @endforeach
   <!-- The option field template containing an option field and a Remove button -->
   <div class="form-group hidden field_wrapper" id="optionTemplate">

   </div>
   <div class="form-group col-sm-12">
        <button type="submit" class="btn btn-success">Submit</button>
   </div>

      {!! Form::close() !!}
  </div>

</div>
