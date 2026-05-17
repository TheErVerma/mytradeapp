@extends('base')

@section('content')

  <div class="main_log_reg_form">
    <h2>Login</h2>
    <p>Lorem ipsum, dolor sit amet consetur adsicing elit. Minus, quibusdam amet consetur.</p>
    <form action="" id="login_form">
      <div class="form_fields">

        <div class="form_field">
          <label for="email_address">Email</label>
          <input type="text" name="email_address" id="email_address" required />
        </div>
        <div class="form_field">
          <label for="password">Password</label>
          <input type="text" name="password" id="password" required />
        </div>
      </div>

      <div class="form_notices"></div>
        <!-- <div class="form_notice">Empty Message</div>
        <div class="form_notice success">Login Success</div>
        <div class="form_notice warning">Login Failed</div>
        <div class="form_notice error">Something Wrong</div> -->

      <div class="form_action_btn_outer">
        <span class="text">Don't have an account? <a href="/register">Register</a>.</span>
        <div class="form_action_btns">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </div>

    </form>

  </div>

@endsection