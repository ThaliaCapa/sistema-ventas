<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Redirección después de restablecer la contraseña.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Diagnóstico temporal.
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $status = Password::reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        dd($status);

        return $status == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $status)
                    : $this->sendResetFailedResponse($request, $status);
    }
}