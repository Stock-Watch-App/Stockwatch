<?php

namespace App\Http\Admin\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.edit');
    }

    public function store(Request $request)
    {
        $result = false;

        $data = $request->all();

        //todo map data into user model and save

        return $result;
    }

    public function show($id)
    {
        $user = User::find($id);

        if (auth()->user()->id === $id // if we are viewing our own profile
            || auth()->user()->can('edit permissions') // or we are allowed to see permissions
        ) {
            $user->load('roles', 'permissions');
        }

        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();

        //todo map data into user model and save

        return redirect()->route('user.show', ['id' => $id]);
    }

    public function ban($id)
    {
        $user = User::find($id);
        $user->banned = true;
        return $user->save();
    }

    public function unban($id)
    {
        $user = User::find($id);
        $user->banned = false;
        return $user->save();
    }

    public function destroy($id)
    {
        $result = false;

        return $result;
    }
}
