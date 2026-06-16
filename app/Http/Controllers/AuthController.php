<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Google\Service\Drive;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login', [
            'googleConfigured' => filled(config('services.google.client_id')) && filled(config('services.google.client_secret')),
        ]);
    }

    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes([Drive::DRIVE_FILE])
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent',
            ])
            ->stateless()
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            $message = 'Login Google gagal. Periksa GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, dan GOOGLE_REDIRECT_URI di file .env.';

            if (str_contains($e->getMessage(), 'invalid_client')) {
                $message = 'Login Google gagal karena Client Secret tidak valid. Salin ulang GOOGLE_CLIENT_SECRET dari Google Cloud Console ke file .env.';
            }

            return redirect()->route('login')->with('error', $message);
        }

        $user = User::query()->firstOrNew(['email' => $googleUser->getEmail()]);
        $user->fill([
            'google_id' => $googleUser->getId(),
            'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: $googleUser->getEmail(),
            'avatar' => $googleUser->getAvatar(),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken ?: $user->google_refresh_token,
        ])->save();

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
