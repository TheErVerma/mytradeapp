@extends('../layout/base')

@section('content')

  <div class="main_log_reg_form">
    <h2>Login</h2>
    <p>Lorem ipsum, dolor sit amet consetur adsicing elit. Minus, quibusdam amet consetur.</p>
    <form action="" id="login_form">
      @csrf
      <div class="form_fields">

        <div class="form_field">
          <label for="email_address">Email</label>
          <input type="text" name="email_address" id="email_address" required />
        </div>
        <span class="forget_pass_link"><a href="/forget-password">Forget Password?</a></span>
        <div class="form_field">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required />
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

<script>
document.getElementById('login_form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const notices = this.querySelector('.form_notices');
    notices.innerHTML = '';

    const payload = {
        email_address: document.getElementById('email_address').value,
        password:      document.getElementById('password').value,
    };

    const resp = await fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                         ?? '{{ csrf_token() }}',
        },
        body: JSON.stringify(payload),
    });

    const data = await resp.json();

    // 200 — logged in normally
    // 202 — 2FA required, redirect to challenge page
    if (data.status === 200 || data.status === 202) {
        window.location.href = data.redirect ?? '/';
    } else {
        notices.innerHTML = `<div class="form_notice error">${data.message}</div>`;
    }
});
</script>

@endsection
