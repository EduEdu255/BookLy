<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit()
    {
        return view('app.profile.edit');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'username' => 'required|string|max:45',
            'bio' => 'nullable|string|max:255',
            // 'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $user->username = $request->username;
        $user->bio = $request->bio;
        $user->save();

        return redirect()->route('home');
    }
}
