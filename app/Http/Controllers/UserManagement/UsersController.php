<?php

namespace App\Http\Controllers\UserManagement;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user_management.users', [
            'roles' => Role::all(),
        ]);
    }

    public function all()
    {
        return User::all();
    }

    /**
     * @param $id
     */
    public function find($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->fill($request->toArray());
        $user->save();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $data = $request->toArray();
        $data['password'] = bcrypt('password');

        $user = new User($data);
        $user->save();
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $user->delete();
    }
}
