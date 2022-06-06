<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    //
    public function users()
    {
      // return response()->json(['user'=>auth()->user()],200);
       $data = User::all();
       return $data;
       // console.log($data);
    }
}
