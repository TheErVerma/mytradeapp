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

    $dc_hash_data = json_decode(base64_decode($decrypted), true); 
    if(!is_array($dc_hash_data)){
        return redirect('/');
    }
    
    $dc_email = isset($dc_hash_data['email']) ? $dc_hash_data['email'] : '';
    $dc_type = isset($dc_hash_data['type']) ? $dc_hash_data['type'] : '';
@endphp
@extends('../layout/base')

@section('content')

<section class="min-h-screen overflow-hidden bg-primary px-4 py-12 md:px-8 md:pt-24">
        <div class="mx-auto flex w-full max-w-90 flex-col gap-8">

            <div class="flex flex-col items-center gap-6 text-center">
                <div data-featured-icon="true"
                    class="relative flex shrink-0 items-center justify-center *:data-icon:size-6 bg-primary shadow-xs-skeuomorphic ring-1 ring-primary ring-inset size-12 rounded-[10px] text-fg-secondary">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-icon="true" class="z-1">
                        <path
                            d="m2 7 8.165 5.715c.661.463.992.695 1.351.784a2 2 0 0 0 .968 0c.36-.09.69-.32 1.351-.784L22 7M6.8 20h10.4c1.68 0 2.52 0 3.162-.327a3 3 0 0 0 1.311-1.311C22 17.72 22 16.88 22 15.2V8.8c0-1.68 0-2.52-.327-3.162a3 3 0 0 0-1.311-1.311C19.72 4 18.88 4 17.2 4H6.8c-1.68 0-2.52 0-3.162.327a3 3 0 0 0-1.311 1.311C2 6.28 2 7.12 2 8.8v6.4c0 1.68 0 2.52.327 3.162a3 3 0 0 0 1.311 1.311C4.28 20 5.12 20 6.8 20Z">
                        </path>
                    </svg>
                </div>
                <div class="flex flex-col gap-2 md:gap-3">
                    <h1 class="text-xl font-semibold text-primary md:text-display-xs">Check your email</h1>
                    <p class="text-md text-tertiary">We sent a verification link to <span
                            class="font-medium">{{ $dc_email }}</span>
                    </p>
                </div>
            </div>

            <form action="" id="verify_otp_form">
                <div class="form_notices"></div>
                <input type="hidden" name="verify_type" value="{{ $dc_type }}" />
                <input type="hidden" name="email_address" value="{{ $dc_email }}"/>
                <input type="hidden" name="otp" id="otp" required />
                <div class="flex flex-col items-center gap-6 md:gap-8">

                    <div role="group" class="flex h-max flex-col gap-1.5">
                        <div class="relative flex flex-row gap-2 md:gap-3 h-auto">
                            <input type="number" id="otp_dg1" placeholder="0" class="otp-input" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1);">
                            <input type="number" id="otp_dg2" placeholder="0" class="otp-input" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1);">
                            <input type="number" id="otp_dg3" placeholder="0" class="otp-input" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1);">
                            <input type="number" id="otp_dg4" placeholder="0" class="otp-input" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1);">
                        </div>
                    </div>

                    <div class="w-full">
                        
                        <button type="submit" class="w-full btn btn-lg btn-primary">
                            <span data-text="true" class="transition px-0.5">Verify email</span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="flex flex-col items-center gap-8 text-center">

                <p class="flex gap-1">
                    <span class="text-sm text-tertiary">Didn't receive the email?</span>
                    <a class="form-footer__link" href="/react#" tabindex="0">
                        <span data-text="true" class="transition">Click to resend</span>
                    </a>
                </p>

                @if($dc_type == 'register')
                <a class="form-grey__link" href="/react#" tabindex="0" data-react-aria-pressable="true">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-icon="leading"
                        class="pointer-events-none size-5 shrink-0 transition">
                        <path d="M19 12H5m0 0 7 7m-7-7 7-7">

                        </path>
                    </svg>
                    <span data-text="true" class="transition">Back to log in</span>
                </a>
                @endif
            </div>

        </div>

    </section>

@endsection