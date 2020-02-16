<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $provider_user = Socialite::driver($provider)->user();
        $user = $this->createOrGetUser(Socialite::driver($provider)->user(), $provider);

        Auth::login($user);

        return redirect()->to('/home');
    }

    private function createOrGetUser($providerUser, $provider)
    {
        $user = User::where('provider', $provider)
                    ->where('provider_user_id', $providerUser->getId())
                    ->first();

        if ($user) {
            //Return account if found
            return $user;
        } else {

            //Check if user with same email address exist
            $user = User::where('email', $providerUser->getEmail())->first();

            //Create user if dont'exist
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName()
                    'provider'         => $provider
                    'provider_user_id' => $providerUser->getId(),
                ]);

            }

            return $user;
        }
    }
}
