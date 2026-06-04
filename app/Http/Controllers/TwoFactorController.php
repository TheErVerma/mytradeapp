<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class TwoFactorController extends Controller
{
    /**
     * Enable 2FA for the authenticated user.
     */
    public function enable(Request $request, EnableTwoFactorAuthentication $enable)
    {
        $enable($request->user());

        return response()->json([
            'success' => true,
            'message' => '2FA setup initiated. Please scan the QR code.',
        ]);
    }

    /**
     * Return the QR code SVG and secret key for setup.
     */
    public function setup(Request $request)
    {
        $user = $request->user();

        if (is_null($user->two_factor_secret)) {
            return response()->json([
                'success' => false,
                'message' => '2FA has not been initiated. Enable it first.',
            ], 400);
        }

        return response()->json([
            'success'    => true,
            'qr_code'    => $user->twoFactorQrCodeSvg(),
            'secret_key' => decrypt($user->two_factor_secret),
        ]);
    }

    /**
     * Confirm (activate) 2FA after the user scans the QR code.
     */
    public function confirm(Request $request, ConfirmTwoFactorAuthentication $confirm)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        try {
            $confirm($request->user(), $request->input('code'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid code. Please try again.',
            ], 422);
        }

        return response()->json([
            'success'        => true,
            'message'        => 'Two-factor authentication enabled successfully.',
            // 'recovery_codes' => json_decode(decrypt($request->user()->two_factor_recovery_codes), true),
        ]);
    }

    /**
     * Disable 2FA for the authenticated user.
     */
    public function disable(Request $request, DisableTwoFactorAuthentication $disable)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $disable($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication has been disabled.',
        ]);
    }

    /**
     * Regenerate recovery codes.
     */
    public function regenerateCodes(Request $request, GenerateNewRecoveryCodes $generate)
    {
        $generate($request->user());

        return response()->json([
            'success'        => true,
            'recovery_codes' => json_decode(decrypt($request->user()->two_factor_recovery_codes), true),
        ]);
    }

    /**
     * Show the 2FA challenge page (after login, before full session).
     */
    public function showChallenge()
    {
        // Redirect away if there's no pending 2FA session
        if (! session('login.id')) {
            return redirect('/login');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the 2FA code during login challenge.
     */
    public function challenge(Request $request)
    {
        $request->validate([
            'code'          => ['nullable', 'string'],
            // 'recovery_code' => ['nullable', 'string'],
        ]);

        $provider = app(TwoFactorAuthenticationProvider::class);

        $user = \App\Models\User::findOrFail(session('login.id'));

        // Verify TOTP code
        if ($request->filled('code')) {
            $valid = $provider->verify(
                decrypt($user->two_factor_secret),
                $request->input('code')
            );

            if (! $valid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid authentication code.',
                ], 422);
            }
        }

        // Verify recovery code
        /* elseif ($request->filled('recovery_code')) {
            $codes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            $inputCode = $request->input('recovery_code');

            $matchedIndex = null;
            foreach ($codes as $index => $code) {
                if (hash_equals($code, $inputCode)) {
                    $matchedIndex = $index;
                    break;
                }
            }

            if (is_null($matchedIndex)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid recovery code.',
                ], 422);
            }

            // Invalidate the used recovery code
            unset($codes[$matchedIndex]);
            $user->two_factor_recovery_codes = encrypt(json_encode(array_values($codes)));
            $user->save();
        }  */
        
        else {
            return response()->json([
                'success' => false,
                'message' => 'Please provide an authentication code or a recovery code.',
            ], 422);
        }

        // Complete the login
        Auth::loginUsingId($user->id);
        session()->forget('login.id');
        $request->session()->regenerate();

        return response()->json([
            'success'  => true,
            'redirect' => '/',
        ]);
    }
}
