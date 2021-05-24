<?php

namespace App\Http\Controllers\UserManagement;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user_management.roles');
    }

    public function all()
    {
        return Role::all();
    }

    /**
     * @param $id
     */
    public function find($id)
    {
        return Role::findOrFail($id);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'description' => 'required',
        ]);

        $user = Role::findOrFail($id);

        $user->fill($request->toArray());
        $user->save();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'description' => 'required',
        ]);

        $data = $request->toArray();

        $user = new Role($data);
        $user->save();
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function delete(Request $request, $id)
    {
        $user = Role::findOrFail($id);
        
        $user->delete();
    }
}
