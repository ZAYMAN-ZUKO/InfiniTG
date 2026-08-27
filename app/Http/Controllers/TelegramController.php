<?php

namespace App\Http\Controllers;

use App\Services\Telegram\TelegramAuthService;
use App\Services\Telegram\TelegramClient;
use Illuminate\Http\Request;
use App\Services\Telegram\TelegramFileService;

class TelegramController extends Controller
{
    protected function authService(): TelegramAuthService
    {
        $client = new TelegramClient(
            'user_' . auth()->id() . '.madeline'
        );

        return new TelegramAuthService($client);
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
        ]);

        return response()->json(
            $this->authService()->sendCode($request->phone)
        );
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        return response()->json(
            $this->authService()->verifyCode($request->code)
        );
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        return response()->json(
            $this->authService()->verifyPassword($request->password)
        );
    }

    public function me()
    {
        return response()->json(
            $this->authService()->getMe()
        );
    }

    public function logout()
    {
        return response()->json(
            $this->authService()->logout()
        );
    }
}
