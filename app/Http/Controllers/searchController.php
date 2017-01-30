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
                   ->paginate(3);
        }
        return View('admin.userindex', compact('datas'))->with('i', ($request->input('name', 1) - 1) * 5);

        // $products = $datas->paginate(3); //get 50 data per page
        // $products->setPath(''); //in case the page generate '/?' link.
        // $pagination = $products->appends(array('search_content' => $request->get('search')));
        // //this will append the url with your search terms
        //
        // return view('admin.userindex')->with('datas', $products)->with('pagination', $pagination);
    }
}
