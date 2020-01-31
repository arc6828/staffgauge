<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';

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
     * Social Login
     */
    public function redirectToProvider($provider = 'line')
    {
        //return Socialite::driver($provider)->redirect();
        return Socialite::with($provider)->redirect();
    }

    public function handleProviderCallback(Request $request,$provider = 'line')
    {
        //$providerUser = Socialite::driver($provider)->user();
        $providerUser = Socialite::driver($provider)->user();
        //$accessTokenResponseBody = $providerUser->accessTokenResponseBody;
            
        $user = $this->createOrGetUser($provider, $providerUser);
        //auth()->login($user);
        //Auth::login($user);
        Auth::loginUsingId($user->id);

        return redirect()->to('/home');
    }

    public function createOrGetUser($provider, $providerUser)
    {
        /** Get Social Account */
        /*$account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();*/
            

        $profile = Profile::firstOrCreate(
            ['lineid' => $providerUser->getId()],
            [
                'lineid' => $providerUser->getId(),
                'provider' => $provider
            ]
        );
        //echo print_r($profile->user);
        

        if ($profile->user_id) {
            return $profile->user;
        } else {
            //มี Profile แล้วแต่ใน Profile ยังไม่มี user_id เพราะต้องสร้าง User ด้วย

            /** Get user detail */
            $userDetail = Socialite::driver($provider)->userFromToken($providerUser->token);

            /** Create new account */
            /*$account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider,
            ]);
            */

            /** Get email or not */
            $email = !empty($providerUser->getEmail()) ? $providerUser->getEmail() : $providerUser->getId() . '@' . $provider . '.com';

            /** Get User Auth */
            if (auth()->check()) {
                $user = auth()->user();
            }else{
                $user = User::whereEmail($email)->first();
            }

            if (!$user) {
                /** Get Avatar */
                $image = $provider . "_" . $providerUser->getId() . ".png";
                $imagePath = public_path(config('app.media.directory') . "users/avatar/" . $image);
                file_put_contents($imagePath, file_get_contents($providerUser->getAvatar()));


                /** Create User */
                $user = User::create([
                    'email' => $email,
                    'name' => $providerUser->getName(),
                    'username' => $providerUser->getId(),
                    'avatar' => $image,
                    'password' => bcrypt(rand(1000, 9999)),
                ]);

            }

            /** Attach User & Social Account */
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
