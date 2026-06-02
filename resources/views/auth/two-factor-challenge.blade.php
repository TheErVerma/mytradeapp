@extends('../layout/base')

@section('content')

<div class="main_log_reg_form">
    <h2>Two-Factor Authentication</h2>
    <p>Open your authenticator app and enter the 6-digit code, or use one of your recovery codes.</p>

    {{-- Tab toggle --}}
    <!-- <div class="tfa_tabs">
        <button type="button" class="tfa_tab active" id="tab_code">Authenticator Code</button> -->
        {{-- <button type="button" class="tfa_tab" id="tab_recovery">Recovery Code</button> --}}
    <!-- </div> -->

    <form action="" id="tfa_challenge_form">
        {{-- TOTP code panel --}}
        <div id="panel_code">
            <div class="form_fields">
                <div class="form_field">
                    <label for="code">6-Digit Code</label>
                    <input type="text" name="code" id="code"
                           inputmode="numeric" autocomplete="one-time-code"
                           maxlength="6" placeholder="000000" />
                </div>
            </div>
        </div>

        {{-- Recovery code panel (hidden by default) --}}
        {{-- <div id="panel_recovery" style="display:none;">
            <div class="form_fields">
                <div class="form_field">
                    <label for="recovery_code">Recovery Code</label>
                    <input type="text" name="recovery_code" id="recovery_code"
                           autocomplete="off" placeholder="xxxx-xxxx-xxxx" />
                </div>
            </div>
        </div> --}}

        <div class="form_notices"></div>

        <div class="form_action_btn_outer">
            <span class="text"><a href="/login">← Back to login</a></span>
            <div class="form_action_btns">
                <button type="submit" class="btn btn-primary">Verify</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // const tabCode     = document.getElementById('tab_code');
    // const tabRecovery = document.getElementById('tab_recovery');
    // const panelCode     = document.getElementById('panel_code');
    // const panelRecovery = document.getElementById('panel_recovery');

    // tabCode.addEventListener('click', function () {
    //     tabCode.classList.add('active');
    //     tabRecovery.classList.remove('active');
    //     panelCode.style.display     = '';
    //     panelRecovery.style.display = 'none';
    //     document.getElementById('recovery_code').value = '';
    // });

    /* tabRecovery.addEventListener('click', function () {
        tabRecovery.classList.add('active');
        tabCode.classList.remove('active');
        panelRecovery.style.display = '';
        panelCode.style.display     = 'none';
        document.getElementById('code').value = '';
    }); */

    // Form submit
    document.getElementById('tfa_challenge_form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const notices = this.querySelector('.form_notices');
        notices.innerHTML = '';

        const payload = {
            code:          document.getElementById('code').value.trim(),
            // recovery_code: document.getElementById('recovery_code').value.trim(),
        };

        const resp = await fetch('/two-factor-authenticate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                             ?? '{{ csrf_token() }}',
            },
            body: JSON.stringify(payload),
        });

        const data = await resp.json();

        if (data.success) {
            window.location.href = data.redirect ?? '/';
        } else {
            notices.innerHTML = `<div class="form_notice error">${data.message}</div>`;
        }
    });
});
</script>

@endsection
