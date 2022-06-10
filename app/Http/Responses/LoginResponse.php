<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;


class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {

        if (auth()->user()->clv_tipo_usuario == 1) {
            return $request->wantsJson()
                ? response()->json(['two_factor' => false])
                : redirect()->route('admin-dashboard');
        }

        if (auth()->user()->clv_tipo_usuario == 2) {
            return $request->wantsJson()
                ? response()->json(['two_factor' => false])
                : redirect()->route('maestro-dashboard');
        }

        if (auth()->user()->clv_tipo_usuario == 3) {
            return $request->wantsJson()
                ? response()->json(['two_factor' => false])
                : redirect()->route('alumno-dashboard');
        }

        if (auth()->user()->clv_tipo_usuario == 4) {
            return $request->wantsJson()
                ? response()->json(['two_factor' => false])
                : redirect()->route('dashboard');
        }

    /**     return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended(config('fortity.home'));
             */
    }
}
