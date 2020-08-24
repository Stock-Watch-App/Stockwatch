<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function account(Request $request)
    {
        $user = $request->user();
        $user->load(['banks', 'avatar']);
        return view('account', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->all();

        $request->validate([
            'name' => 'required|unique:users',
        ]);

        $user->name = $data['name'];
        $user->save();

        return redirect()->route('account.edit');
    }

    public function useAvatar($type)
    {
        $user = auth()->user();

        switch ($type) {
            case 'custom':
                $user->use_robot_avatar = false;
                break;
            case 'robot':
                $user->use_robot_avatar = true;
                break;
        }

        $user->save();
    }
}
