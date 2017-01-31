@extends('layouts.header')
<title>User add Section @yield('title')</title>
@section('content')
<div class="container">
  <div class="col-sm-5 pull-left manually_add well">
    <h1>Add New Participants</h1>
    @if (count($errors) > 0)
       <div class="alert alert-danger">
           <strong>Whoops! Some error occurred.</strong><br><br>
           <ul>
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif
      {!! Form::open(array('route' => 'addusers.store','method'=>'POST','id'=>'surveyForm')) !!}
      <div class="form-group">
           <input type="text" class="form-control" placeholder="First Name" name="fname" />
      </div>
      <div class="form-group">
           <input type="text" class="form-control" name="lname" placeholder="Last Name"/>
      </div>
   <div class="form-group">
           <input type="text" class="form-control" name="email" placeholder="Email" />
   </div>

   <div class="form-group">
       <div class="field_wrapper">
         <input type="text" class="form-control" name="demographic_data[]" placeholder="Others"/>
         <a href="javascript:void(0);" class="addButton" title="Add field"><img src="/images/1484060710_plus.png" alt="" /></a>
       </div>
 </div>
   <!-- The option field template containing an option field and a Remove button -->

   <div class="form-group hidden field_wrapper" id="optionTemplate">

   </div>
   <div class="form-group">
        <button type="submit" class="btn btn-success">Submit</button>
   </div>
      {!! Form::close() !!}
  </div>
  <div class="col-sm-6 pull-right well user_import ">
    <h1>Bulk Import Participants</h1>
    @if(Session::get('msg'))

      <div class="alert alert-danger">
        <a class="close" onclick="$('.alert').hide()">X</a>
        @if(Session::get('msg')!="Heading Mismatch line @ 1 . (first_name,last_name,email,demographic_data) Plz enter this format.")
           <strong>Whoops! Some error occurred.</strong><br><br>
        <ul>
          @foreach(Session::get('msg') as $value)
            <li>{{$value}}</li>
          @endforeach
        </ul>
        @else
          {{Session::get('msg')}}
        @endif
      </div>
    @endif
    <form action="{{ URL::to('importExcel') }}" class="form-horizontal" method="POST" id="import_process" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group">
            <input type="file" class="form-control filestyle" placeholder="File type:xls,xlsx" name="import_file" id="upload" accept=".xls, .xlsx"/>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-success" name="name" value="Import File" id="file"  onchange="checkfile(this);" >
      </div>
    </form>
</div>

</div>
@endsection
