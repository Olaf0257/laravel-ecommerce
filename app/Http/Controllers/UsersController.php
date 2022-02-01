<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display profile of the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();

        return view('my-profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|min:3|max:255|email|unique:users,email,' . auth()->id(),
            'new_password' => 'sometimes|nullable|min:6|confirmed'
        ]);

        $user = auth()->user();
        $user->fill($request->except('old_password', 'new_password', 'new_password_confirmation'));
        $message;

        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = bcrypt($request->new_password);

                if ($user->isDirty('name') || $user->isDirty('email')) {
                    $message = 'Your profile has been updated.';
                } else {
                    $message = 'Your password has been updated.';
                }
            } else {
                return back()->withErrors(['old_password' => 'Your old password is incorrect']);                
            }
        } else if ($request->filled('old_password') && ! $request->filled('new_password')) {
            return back()->withErrors(['new_password' => 'You need to enter a new password in order to change it']);                
        } else if ($request->filled('new_password') && ! $request->filled('old_password')) {
            return back()->withErrors(['old_password' => 'You need to enter your old password in order to change it']);                
        }

        $message = $message ?? 'Your profile has been updated.';
        $user->save();

        return back()->with('success-message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
