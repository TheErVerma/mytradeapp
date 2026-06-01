<?php

/**
 * ─────────────────────────────────────────────────────────────────────────────
 * config/fortify.php  — relevant 2FA settings
 * ─────────────────────────────────────────────────────────────────────────────
 *
 * After running `php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"`
 * open config/fortify.php and make sure the following values are set:
 */

return [

    // 1. Enable the two-factor feature
    'features' => [
        // \Laravel\Fortify\Features::registration(),
        // \Laravel\Fortify\Features::resetPasswords(),
        \Laravel\Fortify\Features::twoFactorAuthentication([
            'confirm'        => true,   // require confirmation before activating
            'confirmPassword' => false, // set to true to also ask for current password on enable
        ]),
    ],

];


/**
 * ─────────────────────────────────────────────────────────────────────────────
 * app/Models/User.php  — add the TwoFactorAuthenticatable trait
 * ─────────────────────────────────────────────────────────────────────────────
 *
 * Add  `use Laravel\Fortify\TwoFactorAuthenticatable;`  to your User model
 * and include it in the `use` block inside the class, e.g.:
 *
 *   use Laravel\Fortify\TwoFactorAuthenticatable;
 *
 *   class User extends Authenticatable
 *   {
 *       use HasFactory, Notifiable, TwoFactorAuthenticatable;
 *       ...
 *   }
 *
 * This trait provides: twoFactorQrCodeSvg(), twoFactorQrCodeUrl(),
 * and access to the encrypted columns.
 */


/**
 * ─────────────────────────────────────────────────────────────────────────────
 * app/Providers/FortifyServiceProvider.php  — disable built-in 2FA routes
 * ─────────────────────────────────────────────────────────────────────────────
 *
 * Since we're using our own routes/controllers, tell Fortify NOT to register
 * its default routes so there are no conflicts.  Add this inside boot():
 *
 *   public function boot(): void
 *   {
 *       Fortify::ignoreRoutes();
 *       // ... rest of your boot code
 *   }
 */
