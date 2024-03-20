<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;

class GoogleSocialiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser, true);

                return redirect('/login');
            } else {
                $existedUser = User::where('email', $user->email)->first();
                if($existedUser) {
                    $newUser = User::where('email', $user->email)->update([
                        'social_id' => $user->id,
                        'social_type' => 'google',
                    ]);
                    $newUser = $existedUser;
                }else {
                    $newUser = User::create(
                        [
                            'name' => $user->name,
                            'email' => $user->email,
                            'social_id' => $user->id,
                            'social_type' => 'google',
                            'password' => encrypt('my-google'),
                            'avatar' => $user->avatar
                        ]
                    );

                }
                Auth::login($newUser, true);

                return redirect('/dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
