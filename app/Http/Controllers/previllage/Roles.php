<?php

namespace App\Http\Controllers\previllage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\backend\Role;


class Roles extends Controller
{
  public function roles() {
    $roles = Role::all();
    return view('content.previllage.roles', compact('roles'));
  }

  public function RoleSave(Request $request)
  {
      $request->validate([
          'name' => 'required',
          'role' => 'required',
      ]);

      // Create the role
      Role::create($request->all());

      // Redirect back to the roles page with success message
      return redirect()->route('roles')->with('message', 'Role created successfully');
  }


  public function RoleEdit($id)
  {dd($id);
      $role = Role::find($id);
      return response()->json($role);
  }

  public function RoleUpdate(Request $request, $id)
  {
      $request->validate([
          'name' => 'required',
          'role' => 'required',
      ]);

      // Find the role and update
      $role = Role::find($id);
      $role->update($request->all());

      // Redirect back to the roles page with success message
      return redirect()->route('roles')->with('message', 'Role updated successfully');
  }

  public function RoleDelete($id)
  {
      // Find and delete the role
      Role::find($id)->delete();

      // Redirect back to the roles page with success message
      return redirect()->route('roles')->with('message', 'Role deleted successfully');
  }


}
