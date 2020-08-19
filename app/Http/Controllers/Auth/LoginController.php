<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Image;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     */
    public function handleProviderCallback($provider)
    {
        $user = $this->createOrGetUser(Socialite::driver($provider)->user(), $provider);
        Auth::login($user);

        return redirect('/');
    }

    private function createOrGetUser($providerUser, $provider)
    {
        if (User::where('provider', $provider)->where('provider_user_id', $providerUser->getId())->get()->count() > 1) {
            Session::flash('error', 'Unable to process request. Error: User Collision has occurred.', true);
            abort(500);
        }

        $user = User::where('provider', $provider)
                    ->where('provider_user_id', $providerUser->getId())
                    ->first();

        if ($user) {
            if (!$user->hasVerifiedEmail()) {
                // let sso "verify" emails for us
                $user->markEmailAsVerified();
            }
            //Return account if found
            return $user;
        } else {
            $email = $providerUser->getEmail() ?? $providerUser->user['email'];

            if ($email !== null && $email !== '') {
                if (User::where('email', $email)->get()->count() > 1) {
                    Session::flash('error', 'Unable to process request. Error: Account Collision has occurred.', true);
                    abort(500);
                }

                //Check if user with same email address exist
                $user = User::where('email', $email)->first();
            } else {
                //when email is empty, set null to prevent mysql integrity constraint violation errors during creation
                $email = null;
            }


            //Create user if don't exist
            if (!$user) {
                $user = User::create([
                    'email' => $email,
                    'name'  => $providerUser->getName(),
                ]);
                $user->provider = $provider;
                $user->provider_user_id = $providerUser->getId();
                $user->setAvatar($providerUser->getAvatar());
                $user->save();

                $user->markEmailAsVerified();
            }

            return $user;
        }
    }
}
