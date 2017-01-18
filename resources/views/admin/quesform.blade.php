@extends('layouts.header')
<div class="container">
  <div class="row">
    <div class="col-sm-8 col-md-8 col-lg-8">
      <form action="{{ URL::to('storeQues') }}" class="form-horizontal" method="post" id="import_process" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group">
          <div class="">
            <input type="file" class="form-control" name="import_file"/>
          </div>
      </div>
      <input type="submit" class="btn btn-primary" name="name" value="Import File" id="file" >
    </form>
    </div>
  </div>
</div>
