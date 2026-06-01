@extends('../layout/base')

@section('content')

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
          <button type="submit" class="btn btn-primary">Send OTP</button>
          <a href="/login" class="btn btn-secondary">Cancel</a>
        </div>
      </div>

    </form>
  </div>

  <div class="main_log_reg_form verify_otp_form" style="display:none;">
    <h2>Verify Account</h2>
    <p>We sent you an OTP to your email address. Please write in the below field.</p>
    <form action="" id="verify_otp_form">
      @csrf
      <input type="hidden" name="email_address" />
      <div class="form_fields">

        <div class="form_field">
          <label for="otp">Password</label>
          <input type="number" name="otp" id="otp" required />
        </div>
      </div>

      <div class="form_notices"></div>
      <div class="form_action_btn_outer">
        <div class="form_action_btns">
          <button type="submit" class="btn btn-primary">Reset Password</button>
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
          <button type="submit" class="btn btn-primary">Reset Password</button>
        </div>
      </div>

    </form>
  </div>

@endsection