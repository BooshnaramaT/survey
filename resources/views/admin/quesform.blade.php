@extends('layouts.header')

<div class="container">
  <div class="row">
    <div class="col-sm-8 col-md-8 col-lg-8 well">
      <h1>Bulk Import Quesitons</h1>
      @if(Session::get('msg'))
        @if(Session::get('msg')=="Sucessfull datas imported.")
        <div class="alert alert-success">
          {{Session::get('msg')}}
        </div>
      @else
          <div class="alert alert-danger">
          <a class="close" onclick="$('.alert').hide()">X</a>
          @if(Session::get('msg')=="Header Mismatch line@ 1. (survey_id, question_text, question_type, question_required, question_enabled, question_dimension, display_order, options, option_weight) Plz enter this format.")
            {{Session::get('msg')}}
          @else
            @foreach(Session::get('msg') as $value)
              <li>{{$value}}</li>
            @endforeach
          @endif
          </div>
        @endif
      @endif
      <form action="{{ URL::to('storeQues') }}" class="form-horizontal" method="post" id="import_process" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
              <input type="file" class="form-control filestyle" name="import_file" id="upload" accept=".xls, .xlsx"/>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" name="name" value="Import File" id="file">
        </div>
    </form>
    </div>
  </div>
</div>
