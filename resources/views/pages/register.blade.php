@extends('../layout/base')

@section('content')
  <div class="main_log_reg_form">
    <h2>Register</h2>
    <p>Lorem ipsum, dolor sit amet consetur adsicing elit. Minus, quibusdam amet consetur.</p>
    <form action="" id="register_form">
      @csrf
      <div class="form_fields">

        <div class="form_field_group">
          <div class="form_field">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" required />
          </div>
          <div class="form_field">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" required />
          </div>
        </div>
        <div class="form_field">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" required />
        </div>
        <div class="form_field">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required />
        </div>
      </div>

      <div class="g-recaptcha" id="rcaptcha" data-theme="light" data-sitekey="6LfqhAItAAAAAN9WGjDB7vPoAwEUmqj7c2V6SmUc"></div>

      <div class="form_notices"></div>

      <div class="form_action_btn_outer">
        <span class="text">Already have an account? <a href="/login">Login</a>.</span>
        <div class="form_action_btns">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </div>

    </form>

  </div>

@endsection