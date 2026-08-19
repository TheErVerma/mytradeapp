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
              d="M17 9a1.99 1.99 0 0 0-.586-1.414A1.994 1.994 0 0 0 15 7m0 8a6 6 0 1 0-5.946-5.193c.058.434.087.651.068.789a.853.853 0 0 1-.117.346c-.068.121-.187.24-.426.479l-5.11 5.11c-.173.173-.26.26-.322.36a1 1 0 0 0-.12.29C3 17.296 3 17.418 3 17.663V19.4c0 .56 0 .84.109 1.054a1 1 0 0 0 .437.437C3.76 21 4.04 21 4.6 21H7v-2h2v-2h2l1.58-1.58c.238-.238.357-.357.478-.425a.852.852 0 0 1 .346-.117c.138-.02.355.01.789.068.264.036.533.054.807.054Z">
            </path>
          </svg>
        </div>

        <div class="flex flex-col gap-2 md:gap-3">
          <h1 class="text-xl font-semibold text-primary md:text-display-xs">Forgot password?</h1>
          <p class="self-stretch text-md text-tertiary">No worries, we'll send you reset instructions.</p>
        </div>

      </div>

      <form class="flex flex-col gap-6" id="forget_password_form">
        @csrf
        <div class="form_notices"></div>
        <div class="group flex h-max w-full flex-col items-start justify-start gap-1.5">

          <label class="form-label">Email<span class="text-brand-tertiary">*</span>
          </label>

          <input type="email" required="" placeholder="Enter your email" tabindex="0" class="form-input" data-rac=""
            name="email_address" value="" title="">

        </div>

        <div class="flex flex-col gap-4">
          <button class="btn btn-lg btn-primary" type="submit" tabindex="0">
            <span data-text="true" class="transition-inherit-all px-0.5">Reset password</span>
          </button>
        </div>

      </form>

      <div class="flex justify-center gap-1 text-center">
        <a class="form-grey__link" data-rac="" href="/login" tabindex="0" data-react-aria-pressable="true">
          <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-icon="leading"
            class="pointer-events-none size-5 shrink-0 transition">
            <path d="M19 12H5m0 0 7 7m-7-7 7-7"></path>
          </svg>
          <span data-text="true" class="transition">Back to log in</span>
        </a>
      </div>
    </div>
  </section>

  @php
  
  /*
  <div class="main_log_reg_form forget_password_form">
    <h2>Forget Password</h2>
    <p>Enter your registered email address below.</p>
    <form action="" id="forget_password_form">
      @csrf
      <div class="form_fields">

        <div class="form_field">
          <label for="email_address">Email</label>
          <input type="text" name="email_address" id="email_address" required />
        </div>
      </div>

      <div class="form_notices"></div>
      <div class="form_action_btn_outer">
        <div class="form_action_btns">
          <button type="submit" class="btn btn-md btn-primary">Send OTP</button>
          <a href="/login" class="btn btn-md btn-secondary">Cancel</a>
        </div>
      </div>

    </form>
  </div>

  <div class="main_log_reg_form verify_otp_form" style="display:none;">
    <h2>Verify Account</h2>
    <p>We sent you an OTP to your email address. Please write in the below field.</p>
    <form action="" id="verify_otp_form">
      @csrf
      <input type="hidden" name="verify_type" value="forget_password" />
      <input type="hidden" name="email_address" />
      <div class="form_fields">

        <div class="form_field">
          <label for="otp">OTP</label>
          <input type="number" name="otp" id="otp" required />
        </div>
      </div>

      <div class="form_notices"></div>
      <div class="form_action_btn_outer">
        <div class="form_action_btns">
          <button type="submit" class="btn btn-md btn-primary">Verify</button>
        </div>
      </div>

    </form>
  </div>

  <div class="main_log_reg_form reset_password_form" style="display:none;">
    <h2>Reset Password</h2>
    <p>Create a new password and make sure it is strong and secure.</p>
    <form action="" id="reset_password_form">
      @csrf
      <input type="hidden" name="email_address" />
      <div class="form_fields">

        <div class="form_field">
          <label for="new_password">Password</label>
          <input type="password" name="new_password" id="new_password" required />
        </div>
      </div>

      <div class="form_notices"></div>
      <div class="form_action_btn_outer">
        <div class="form_action_btns">
          <button type="submit" class="btn btn-md btn-primary">Reset Password</button>
        </div>
      </div>

    </form>
  </div>*/

  @endphp

@endsection