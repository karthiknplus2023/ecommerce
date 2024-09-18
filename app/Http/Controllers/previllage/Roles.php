<?php

namespace App\Http\Controllers\previllage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\backend\Role;


class Roles extends Controller
{
  public function roles()
  {
    $roles = Role::get();
    return view('content.previllage.roles',compact('roles'));
  }

}
