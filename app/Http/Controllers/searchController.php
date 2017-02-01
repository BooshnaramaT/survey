<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\addusers;
use Illuminate\Support\Facades\DB;

class searchController extends Controller
{
    public function searchUsers(Request $request)
    {
        $content= $request->get('search');
        if ($content=="") {
          $datas = addusers::all();
          $datas = addusers::paginate(5);
        }
        else {
          $datas = addusers::where('fname'  , 'like', '%' . $content. '%')
                   ->orwhere('lname'  , 'like', '%' .  $content. '%')
                   ->orwhere('email'  , 'like', '%' .  $content. '%')
                   ->paginate(5);
        }

        return View('admin.userindex', compact('datas'));

    }
}
