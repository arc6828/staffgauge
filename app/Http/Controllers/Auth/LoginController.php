<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Profile;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
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
            // ตรวจสอบ lineid ว่า = $providerUser->getId() หรือไม่ ถ้าไม่ใช่ก็ไประบุ
            ['lineid' => $providerUser->getId()] , ['photo' => $providerUser->getAvatar() , 'role' => 'guest']
            
        );
        //echo print_r($profile->user);
        

        if ($profile->user_id) {
            return $profile->user;
        } else {
            //มี Profile แล้วแต่ใน Profile ยังไม่มี user_id เพราะต้องสร้าง User ด้วย

            
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => Hash::make('123456789')
            ]);
            
            // $profile = $user->id;
            $profile->update(['user_id' => $user->id]); 

            echo "<br> ID : ".$providerUser->getId();
            echo "<br> nickname : ".$providerUser->getNickname();
            echo "<br> name : ".$providerUser->getName();
            echo "<br> email : ".$providerUser->getEmail();
            echo "<br> avatar : ".$providerUser->getAvatar();

            return $user;
            // return null;
        }
    }
}
