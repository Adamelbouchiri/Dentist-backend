<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->stateless()->scopes(['email'])->redirect();
    }

    public function facebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        $email = $facebookUser->getEmail();

        if (!$email) {
            $email = "facebook_" . $facebookUser->getId() . "@facebook.com";
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $facebookUser->getName(),
                'facebook_id' => $facebookUser->getId(),
                'avatar' => $facebookUser->getAvatar(),
                'email_verified_at' => now(),
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect("http://localhost:5173/facebook-auth-success?token=" . urlencode($token));
    }
}

