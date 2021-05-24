<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
    public function create(Request $request)
    {
      $validateUser = $request->validate([
        'name' => 'required|string|between:4,50',
        'email' => 'required|string|between:10,50|email',
        'password' => 'required|string|between:6,50|confirmed',
      ]);

      if ( User::where('email', request('email'))->exists() ) {
          $error = \Illuminate\Validation\ValidationException::withMessages([
               'message' => 'Someone registed this email already',
            ]);
        throw $error;
      }

      $user = User::create([
        'name' => request('name'),
        'email' => request('email'),
        'password' => bcrypt(request('password')),
      ]);

      $token = VerifyEmail::create([
        'user_id' => $user->id,
        'email_token' => Str::random(20)
      ]);

    }

    public function logIn(Request $request)
    {
      $remember = request('remember');
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')], $remember)) {
            $user = User::where('email', request('email'))->first();
            return 'login';
        }
        return response()->json([
            'not_match' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logOut()
    {
      auth()->logout();
      return 'log out';
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
