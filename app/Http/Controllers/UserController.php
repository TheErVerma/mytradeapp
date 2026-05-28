<?php

namespace App\Http\Controllers;

use App\Mail\OTPEmail;
use App\Mail\ResetPassEmail;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email_address" => ['required'],
            "password" => ['required'],
            // "g-recaptcha-response" => ['required'],
        ]);

        $credentials_arr = [
            "email" => $request->input('email_address'),
            "password" => $request->input('password')
        ];

        // Verify captcha with Google
        // $response = Http::asForm()->post(
        //     'https://www.google.com/recaptcha/api/siteverify',
        //     [
        //         'secret' => env('6LeWX-EsAAAAAC6DIG_ELYRnXHHaY8zaG9Zr5032'),
        //         'response' => $request->input('g-recaptcha-response'),
        //         'remoteip' => $request->ip(),
        //     ]
        // );

        // $result = $response->json();

        // if (!($result['success'] ?? false)) {
        //     return array(
        //         "status" => 500,
        //         "message" => "Invalid Captcha",
        //         "data" => $result
        //     );
        // }

        if (Auth::attempt($credentials_arr)) {
            $request->session()->regenerate();
            return array(
                "status" => 200,
                "message" => "Logged In.",
                "redirect" => "/"
            );
        } else {
            return array(
                "status" => 500,
                "message" => "Not logged In."
            );
        }
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            "email" => ['required'],
            "password" => ['required'],
            "g-recaptcha-response" => ['required'],
        ]);

        $user = new User();
        $fist_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $full_name = $fist_name;
        if ($last_name != "") {
            $full_name .= ' ' . $last_name;
        }

        $has_user_email = User::where('email', $request->input('email'))->first();
        if ($has_user_email) {
            return array(
                "status" => 500,
                "message" => "Email Already Exists"
            );
        }

        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->name = $full_name;

        if ($user->save()) {
            $credentials = $request->validate([
                "email" => ['required'],
                "password" => ['required'],
            ]);
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return array(
                    "status" => 200,
                    "message" => "Logged In.",
                    "redirect" => "/"
                );
            } else {
                return array(
                    "status" => 500,
                    "message" => "Not logged In."
                );

            }
        } else {
            return array(
                "status" => 500,
                "message" => "Registeration unsuccessful."
            );
        }
    }


    public function forgetPassword(Request $request)
    {
        $parameters = $request->validate([
            "email_address" => ['required'],
        ]);
        $otp = rand(100000, 999999);
        $user_email = $request->input('email_address');

        $user = User::where('email', $user_email)->first();
        if ($user) {
            $resp = Mail::to($user_email)->send(new OTPEmail($otp, $user->name));

            $user_obj = User::findOrFail($user->id);
            $user_obj->verifyhash = $otp . '|' . time();
            $user_obj->save();

            return response()->json([
                'success' => true,
                'message' => 'OPT Sent',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid Email',
            'email' => $user_email
        ]);
    }


    public function resetPassword(Request $request)
    {
        $parameters = $request->validate([
            "email_address" => ['required'],
            "new_password" => ['required'],
        ]);
        $user_email = $request->input('email_address');

        $user = User::where('email', $user_email)->first();
        if ($user) {
            $resp = Mail::to($user_email)->send(new ResetPassEmail($user->name));

            $user_obj = User::findOrFail($user->id);
            $user_obj->password = Hash::make($request->input('new_password'));
            $user_obj->save();

            return response()->json([
                'success' => true,
                'message' => 'Password Changed',
                'redirect' => '/login'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid Request',
        ]);
    }


    public function verifyOTP(Request $request)
    {
        $parameters = $request->validate([
            "otp" => ['required'],
            "email_address" => ['required'],
        ]);

        $otp = $request->input('otp');
        $user_email = $request->input('email_address');
        $user = User::where('email', $user_email)->first();
        $saved_otp_data = explode('|', $user->verifyhash);
        $saved_otp = isset($saved_otp_data[0]) ? $saved_otp_data[0] : '';
        $saved_time = isset($saved_otp_data[1]) ? $saved_otp_data[1] : '';
        $valid_untill = 600;

        if ($saved_otp == $otp && ($saved_time + $valid_untill) >= time()) {
            return response()->json([
                'success' => true,
                'email' => $user_email,
                'message' => 'OPT Verified',
            ]);
        }
        return response()->json([
            'success' => false,
            'email' => $user_email,
            'message' => 'Invalid OPT',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/login');
    }


    public function saveProfile(Request $request, $id)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'profile_pic' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $f_name = $request->input('first_name');
        $l_name = $request->input('last_name');
        // $email = $request->input('email_address');


        $user = User::findOrFail($id);

        $user->name = $f_name . ' ' . $l_name;


        $response = [
            'success' => true,
        ];

        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic');
            $picName = time() . '.' . $profile_pic->getClientOriginalExtension();
            $profile_pic->storeAs('profile', $picName, 'public');

            $profile_pic_url = asset('storage/profile/' . $picName);

            $file = parse_url($user->profile_pic, PHP_URL_PATH);
            $response['file'] = $file;
            $prevPic = ltrim(str_replace('/storage', '', $file));

            if (Storage::disk('public')->exists($prevPic)) {

                Storage::disk('public')->delete($prevPic);
            }
            $user->profile_pic = $profile_pic_url;

        }

        $response['message'] = 'Profile Updated';

        $user->save();

        return response()->json($response);

    }

    public function saveSettings(Request $request, $id)
    {

        $request->validate([
            'default_country' => ['required'],
            'initial_balance' => ['required'],
        ]);

        $country = $request->input('default_country');
        $init_balance = $request->input('initial_balance');
        
        $user = User::findOrFail($id);

        $user->default_country = $country;
        $user->initial_balance = $init_balance;
        
        $user->save();
        
        $response = [
            'success' => true,
            'message' => 'Settings Saved'
        ];

        return response()->json($response);

    }
}
