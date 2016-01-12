<?php

namespace SisMid\Http\Controllers\Auth;

use Artesaos\Defender\Facades\Defender;
use SisMid\Models\Usuario;
use Validator;
use SisMid\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
// Importing the BotDetectCaptcha class
use LaravelCaptcha\Integration\BotDetectCaptcha;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome' => 'required|max:255',
            'sobrenome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:usuarios',
            'password' => 'required|confirmed|min:6',
            'CaptchaCode' => 'required|valid_captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = Usuario::create([
            'nome' => $data['nome'],
            'sobrenome' => $data['sobrenome'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $role = Defender::findRole('gestor');
        $user->attachRole($role);

        return $user;
    }

    /**
     * Get captcha instance to handle for the login page.
     *
     * @return object
     */
    private function getLoginCaptchaInstance()
    {
        // Captcha parameters:
        $captchaConfig = [
            'CaptchaId' => 'LoginCaptcha', // a unique Id for the Captcha instance
            'UserInputId' => 'CaptchaCode', // Id of the Captcha code input textbox
            // The path of the Captcha config file is inside the config folder
            'CaptchaConfigFilePath' => 'captcha_config/LoginCaptchaConfig.php'
        ];
        return BotDetectCaptcha::GetCaptchaInstance($captchaConfig);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        // captcha instance of the login page
        $captcha = $this->getLoginCaptchaInstance();

        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate', ['captchaHtml' => $captcha->Html()]);
        }

        return view('auth.login', ['captchaHtml' => $captcha->Html()]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required',
            'password' => 'required',
            'CaptchaCode' => 'required|valid_captcha',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage()
            ]);
    }

    /**
     * Get captcha instance to handle for the register page
     *
     * @return object
     */
    private function getRegisterCaptchaInstance()
    {
        // Captcha parameters:
        $captchaConfig = [
            'CaptchaId' => 'RegisterCaptcha', // a unique Id for the Captcha instance
            'UserInputId' => 'CaptchaCode', // Id of the Captcha code input textbox
            // The path of the Captcha config file is inside the config folder
            'CaptchaConfigFilePath' => 'captcha_config/RegisterCaptchaConfig.php'
        ];
        return BotDetectCaptcha::GetCaptchaInstance($captchaConfig);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        // captcha instance of the register page
        $captcha = $this->getRegisterCaptchaInstance();

        // passing Captcha Html to register view
        return view('auth.register', ['captchaHtml' => $captcha->Html()]);
    }
}
