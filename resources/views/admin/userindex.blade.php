@extends('layouts.header')

@section('content')
<title>User index @yield('title')</title>
<script type="text/javascript">

  function ConfirmDelete()
  {
  var x = confirm("Really you want to Delete this user ?");
  if (x)
  {
    return true;
  }
  else
  {
    return false;
   }
  }

</script>
<div class="container">
  <div class="col-sm-12">
    <a href="{{ route('addusers.create') }}" class="btn btn-success pull-right"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add New</a>
    @if(Session::get('msg'))
      <div class="alert alert-success message">{!! Session::has('msg') ? Session::get("msg") : '' !!}</div>
    @endif
    <div class="">
      <form class="form-horizontal" action="{{ URL::to('searchUsers') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group col-sm-5 search_user">
        <input type="text" name="search" value="" class="form-control pull-left" placeholder="First Name,Last Name,Email">
          <button type="submit" name="button" class="btn btn-info pull-left"><span class="fa fa-search"></span>&nbsp;Search</button>
        </div>
      </form>
    </div>
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
              @if($result->fname =="admin")
                <a href="{{ route('addusers.edit',$result->id) }}" data-toggle="tooltip" title="Edit admin details" class="btn btn-info"><span class="fa fa-edit"></span></a>
              @else
              <a href="{{ route('addusers.edit',$result->id) }}" data-toggle="tooltip" title="Edit user details" class="btn btn-info"><span class="fa fa-edit"></span></a>
              <a href="{{URL::action('ResendaccessController@ResendAccess').'?user_id='.$result->id}}" data-toggle="tooltip" title="Resend Access" class="btn btn-info"><span class="fa fa-refresh"></span></a>
                {!! Form::open(['method' => 'DELETE','route' => ['addusers.destroy', $result->id],'id'=>'del_form','onsubmit' => 'return ConfirmDelete()']) !!}
                  <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Delete"><span class="fa fa-trash-o"></span></button>
                {!! Form::close() !!}
              @endif
            </td>

          </tr>
    <?php $s_no++; ?>
      @endforeach
  @else
        <tr><td colspan="4" class="text-center">No Results Found</td></tr>
  @endif
    </table>
    {!! $datas->appends(Input::except('page'))->render() !!}
  </div>
</div>
@endsection
