@extends('layouts.header')
<div class="container">
  <div class="col-sm-12">
    <a href="{{ route('addusers.create') }}" class="btn btn-success pull-right">Add New</a>
    <table class="table table-bordered">
      <th>S.No</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Other</th>
      <th>Actions</th>
  @if(count($datas)!=0)
  <?php $s_no=1; ?>
      @foreach($datas as $result)
          <tr>
            <td>{{$s_no}}</td>
            <td>{{$result->fname}}</td>
            <td>{{$result->lname}}</td>
            <td>{{$result->email}}</td>
            <td>
              <table class="table table-bordered">
                @foreach(unserialize($result->demographic_data) as $key=>$values)
                  <tr>
                    <td><strong>{{$key}}</strong></td>
                    <td>{{$values}}</td>
                  </tr>
                @endforeach
              </table>
            </td>
            <td>
              <a href="{{ route('addusers.edit',$result->id) }}" class="btn btn-info">Edit</a>
                {!! Form::open(['method' => 'DELETE','route' => ['addusers.destroy', $result->id]]) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            </td>
          </tr>
    <?php $s_no++; ?>
      @endforeach
  @else
        <tr><td colspan="4" class="text-center">No Results Found</td></tr>
  @endif
    </table>
    {!! $datas->render() !!}
  </div>
</div>
