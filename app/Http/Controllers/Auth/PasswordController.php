<?php

namespace SisMid\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SisMid\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use LaravelCaptcha\Integration\BotDetectCaptcha;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getNewPassword', 'postNewPassword']]);
    }

    /**
     * Get captcha instance to handle for the email page
     *
     * @return object
     */
    private function getEmailCaptchaInstance()
    {
        // Captcha parameters:
        $captchaConfig = [
            'CaptchaId' => 'Captcha', // a unique Id for the Captcha instance
            'UserInputId' => 'CaptchaCode', // Id of the Captcha code input textbox
            // The path of the Captcha config file is inside the config folder
            'CaptchaConfigFilePath' => 'captcha_config/EmailCaptchaConfig.php'
        ];
        return BotDetectCaptcha::GetCaptchaInstance($captchaConfig);
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmail()
    {
        // captcha instance of the email page
        $captcha = $this->getEmailCaptchaInstance();

        return view('auth.password', ['captchaHtml' => $captcha->Html()]);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'CaptchaCode' => 'required|valid_captcha'
        ]);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Get captcha instance to handle for the reset password page
     *
     * @return object
     */
    private function getResetPasswordCaptchaInstance()
    {
        // Captcha parameters:
        $captchaConfig = [
            'CaptchaId' => 'ResetPasswordCaptcha', // a unique Id for the Captcha instance
            'UserInputId' => 'CaptchaCode', // Id of the Captcha code input textbox
            // The path of the Captcha config file is inside the config folder
            'CaptchaConfigFilePath' => 'captcha_config/ResetPasswordCaptchaConfig.php'
        ];
        return BotDetectCaptcha::GetCaptchaInstance($captchaConfig);
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        // captcha instance of the reset password page
        $captcha = $this->getResetPasswordCaptchaInstance();

        return view('auth.reset')
            ->with('token', $token)
            ->with('captchaHtml', $captcha->Html());
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'CaptchaCode' => 'required|valid_captcha'
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath());

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }


    public function getNewPassword()
    {
        return view('auth.newPassword');
    }

    public function postNewPassword(Request $request)
    {
        $this->validate($request, [
            'oldPassword' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);
        if (Hash::check($request['oldPassword'], Auth::user()->password)) {
            Auth::user()->update(['password' => bcrypt($request['password'])]);
        }
        else {
            return redirect()->back()
                ->withErrors([
                    'Senha atual não confere'
                ]);
        }
        return redirect(route("password.getNewpassword"))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'Senha Atualiada com sucesso'
        ]);
    }
}
