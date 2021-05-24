<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifyEmail;
use App\Models\User;

class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {
      //Grap the $request email token.
      $email_token = $request->email_token;

      //Find the user_id with that token.
      $user_id = VerifyEmail::where('email_token', $email_token)->first()->user_id;

      //Find in user table the user_id and update the email_verify_at equal now()
      $user = User::find($user_id);

      $user->update(['email_verified_at' => time()]);

      return redirect('/login')
                ->with('status', 'Your email is verified already')
                ->with('email', $user->email);

    }
    
}
