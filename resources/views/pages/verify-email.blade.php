@php
    use Illuminate\Contracts\Encryption\DecryptException;

    $hash = isset($_GET['hash']) ? $_GET['hash'] : '';

    $decrypted = '';
    if ($hash == '') {
        return;
    }
    try {
        $decrypted = Crypt::decryptString($hash);
    } catch (DecryptException $e) {
        return response()->json(['error' => 'Decryption failed.'], 400);
    }
    if ($decrypted == '') {
        return redirect('/');
    }
@endphp
@extends('../layout/base')

@section('content')

    <div class="main_log_reg_form verify_otp_form">
        <h2>Verify Account</h2>
        <p>We sent you an OTP to your email address. Please write in the below field.</p>
        <form action="" id="verify_otp_form">
            @csrf
            <input type="hidden" name="verify_type" value="register" />
            <input type="hidden" name="email_address" value="{{ json_decode(base64_decode($decrypted), true);}}"/>
            <div class="form_fields">

                <div class="form_field">
                    <label for="otp">OTP</label>
                    <input type="number" name="otp" id="otp" required />
                </div>
            </div>

            <div class="form_notices"></div>
            <div class="form_action_btn_outer">
                <div class="form_action_btns">
                    <button type="submit" class="btn btn-primary">Proceed</button>
                </div>
            </div>

        </form>
    </div>

@endsection