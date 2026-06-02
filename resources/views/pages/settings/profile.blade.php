@extends('../../layout/base')


@section('content')

    @php
        $user = Auth::user();

        $twoFactorEnabled   = ! is_null($user->two_factor_secret) && !is_null($user->two_factor_confirmed_at);
        $twoFactorConfirmed = ! is_null($user->two_factor_confirmed_at);
    @endphp

    @if(isset($user))

        @php
            $full_name = $user->name;
            $email_adds = $user->email;
            $name_parts = explode(' ', $full_name);
            $first_name = isset($name_parts[0]) ? $name_parts[0] : '';
            $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
        @endphp

        <div class="profile_settings_wrap">
            <div class="profile_settings_inner">

                <div class="prf_set_card_wrapper">
                    <form action="" id="profile_settings_form">
                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                        <div class="prf_set_card profile_head">
                            <div class="p_h_banner"></div>
                            <div class="profile_image">
                                <img src="{{ $user->profile_pic }}" alt="">
                                <input type="file" name="profile_pic" id="profile_pic" accept="images/*" />
                                <span class="icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="13" r="3" stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M9.77778 21H14.2222C17.3433 21 18.9038 21 20.0248 20.2646C20.51 19.9462 20.9267 19.5371 21.251 19.0607C22 17.9601 22 16.4279 22 13.3636C22 10.2994 22 8.76721 21.251 7.6666C20.9267 7.19014 20.51 6.78104 20.0248 6.46268C19.3044 5.99013 18.4027 5.82123 17.022 5.76086C16.3631 5.76086 15.7959 5.27068 15.6667 4.63636C15.4728 3.68489 14.6219 3 13.6337 3H10.3663C9.37805 3 8.52715 3.68489 8.33333 4.63636C8.20412 5.27068 7.63685 5.76086 6.978 5.76086C5.59733 5.82123 4.69555 5.99013 3.97524 6.46268C3.48995 6.78104 3.07328 7.19014 2.74902 7.6666C2 8.76721 2 10.2994 2 13.3636C2 16.4279 2 17.9601 2.74902 19.0607C3.07328 19.5371 3.48995 19.9462 3.97524 20.2646C5.09624 21 6.65675 21 9.77778 21Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path d="M19 10H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="profile_user_info">
                                <h4>{{ $full_name }}</h4>
                                <p>Account Status: Institutional elite</p>
                            </div>
                        </div>

                        <div class="prf_set_card profile_personal_info">
                            <h3>Personal Information</h3>
                            <div class="prf_set_fields">
                                <div class="prf_set_field_group">
                                    <div class="prf_set_field">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" id="first_name" placeholder="Jhon"
                                            value="{{ $first_name }}" />
                                    </div>
                                    <div class="prf_set_field">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name" placeholder="Doe"
                                            value="{{ $last_name }}" />
                                    </div>
                                </div>
                                <div class="prf_set_field_group">
                                    <div class="prf_set_field">
                                        <label for="email_address">Email Address</label>
                                        <input type="text" name="email_address" id="email_address"
                                            placeholder="Jhon@example.com" value="{{ $email_adds }}" />
                                    </div>
                                    <div class="prf_set_field">
                                        <label for="timezone">Time-Zone</label>
                                        <input type="text" name="timezone" id="timezone" placeholder="GMT-05:00"
                                            value="GMT 05:30" />
                                    </div>
                                </div>
                            </div>

                            <div class="form_notices"></div>

                            <div class="prf_set_actions">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>

                    <div class="prf_set_card profile_security">
                        <h3>Security & Privacy</h3>

                        <div class="prf_row_settings">
                            <div class="prf_row_set">
                                <div class="prf_rgt">
                                    <span class="title">Change Password</span>
                                    <span class="description">Update your security credentials regularly</span>
                                </div>
                                <div class="prf_lft">
                                    <button type="button" class="btn btn-secondary">Update</button>
                                </div>
                            </div>
                            {{-- ─── Two-Factor Authentication Card ────────────────────────── --}}
                    <div class="prf_row_set" id="tfa_card">
                        <div class="prf_rgt">
                            <span class="title">Two-Factor Authentication (2FA)</span>
                            <span class="description">Currently active for enhanced security</span>
                        </div>

                        {{-- ── State: NOT enabled ──────────────────────────────────── --}}
                        <div class="prf_lft">
                            <div id="tfa_state_disabled" @if($twoFactorEnabled) style="display:none;" @endif>
                                <div class="main_set_actions">
                                    <button type="button" class="btn btn-primary" id="btn_enable_2fa">Enable 2FA</button>
                                </div>
                            </div>
                        </div>

                        {{-- ── State: enabled but NOT yet confirmed (QR setup step) ── --}}
                        <div id="tfa_state_setup" style="display:none;">
                            
                            <div id="tfa_qr_wrap"></div>
                            <div class="tfa_state_side_content">
                                <p>Scan the QR code below with your authenticator app (Google Authenticator, Authy, etc.), then
                                enter the 6-digit code to confirm.</p>
                                <p>Can't scan? Enter this key manually: <strong id="tfa_secret_key"></strong></p>

                                <div class="main_set_fields">
                                    <div class="main_set_field">
                                        <?php /*<label for="tfa_confirm_code">Confirmation Code</label> */ ?>
                                        <input type="text" id="tfa_confirm_code" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'').slice(0,6)"
                                            maxlength="6" placeholder="000000" autocomplete="off"/>
                                    </div>
                                    <div class="form_notices" id="tfa_setup_notices"></div>
                                    <div class="main_set_actions">
                                        <button type="button" class="btn btn-primary" id="btn_confirm_2fa">Activate</button>
                                        <button type="button" class="btn btn-secondary" id="btn_cancel_setup">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── State: fully enabled & confirmed ───────────────────── --}}
                        <div id="tfa_state_enabled" @if(! $twoFactorConfirmed) style="display:none;" @endif>

                            <div class="main_sub_sets">
                                {{-- Recovery codes --}}
                                {{-- <div class="main_sub_set">
                                    <div class="main_sub_set_inner">
                                        <h4>Recovery Codes</h4>
                                        <p>Store these codes somewhere safe. Each code can be used once if you lose access to
                                        your authenticator app.</p>
                                        <div id="tfa_recovery_codes" style="display:none;"></div>
                                        <button type="button" class="btn btn-secondary" id="btn_show_recovery">
                                            Show / Regenerate Codes
                                        </button>
                                    </div>
                                </div> --}}

                                {{-- Disable 2FA --}}
                                <div class="main_sub_set">
                                    <div class="main_sub_set_inner">
                                        <div id="tfa_disable_form" style="display:none; max-width:260px;">
                                            <div class="main_set_field">
                                                <label for="tfa_disable_password">Current Password</label>
                                                <input type="password" id="tfa_disable_password" autocomplete="current-password" placeholder="xxxxxxx"/>
                                            </div>
                                            <div class="form_notices" id="tfa_disable_notices"></div>
                                            <div class="main_set_actions" style="margin-top:8px;">
                                                <button type="button" class="btn btn-danger" id="btn_confirm_disable">Confirm Disable</button>
                                                <button type="button" class="btn btn-secondary" id="btn_cancel_disable">Cancel</button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger" id="btn_disable_2fa"
                                                @if(! $twoFactorConfirmed) style="display:none;" @endif>
                                            Disable 2FA
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ─── End Two-Factor Authentication Card ────────────────────── --}}
                        </div>
                    </div>

                    

                </div>

            </div>
        </div>
    
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
                const disable2FAButton = document.getElementById('btn_disable_2fa');

                // ── Helpers ────────────────────────────────────────────────────────────

                function setState(name) {
                    if(name == 'setup'){
                        document.getElementById('tfa_card').classList.add('active_2fa');
                    }else{
                        document.getElementById('tfa_card').classList.remove('active_2fa');
                        document.getElementById('tfa_setup_notices').innerHTML = '';
                    }
                    ['disabled', 'setup', 'enabled'].forEach(s => {
                        document.getElementById('tfa_state_' + s).style.display = (s === name) ? '' : 'none';
                    });
                }

                function notice(elId, msg, type = 'error') {
                    const el = document.getElementById(elId);
                    el.innerHTML = `<div class="form_notice ${type}">${msg}</div>`;
                }

                async function apiFetch(url, method = 'GET', body = null) {
                    const opts = {
                        method,
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    };
                    if (body) opts.body = JSON.stringify(body);
                    const resp = await fetch(url, opts);
                    return resp.json();
                }

                // ── Enable 2FA (step 1 — show QR) ─────────────────────────────────────

                document.getElementById('btn_enable_2fa').addEventListener('click', async function () {
                    const data = await apiFetch('/user/two-factor/enable', 'POST');
                    if (! data.success) { alert(data.message); return; }

                    const setup = await apiFetch('/user/two-factor/setup');
                    if (! setup.success) { alert(setup.message); return; }

                    document.getElementById('tfa_qr_wrap').innerHTML = setup.qr_code;
                    document.getElementById('tfa_secret_key').textContent = setup.secret_key;
                    setState('setup');
                });

                // ── Cancel setup ───────────────────────────────────────────────────────

                document.getElementById('btn_cancel_setup').addEventListener('click', function () {
                    setState('disabled');
                });

                // ── Confirm 2FA (step 2 — verify TOTP code) ───────────────────────────

                document.getElementById('btn_confirm_2fa').addEventListener('click', async function () {
                    const code = document.getElementById('tfa_confirm_code').value.trim();
                    if (code.length !== 6) {
                        notice('tfa_setup_notices', 'Please enter the 6-digit code from your app.');
                        return;
                    }

                    const data = await apiFetch('/user/two-factor/confirm', 'POST', { code });

                    if (data.success) {
                        // renderRecoveryCodes(data.recovery_codes);
                        disable2FAButton.style.display = '';
                        setState('enabled');
                    } else {
                        notice('tfa_setup_notices', data.message ?? 'Invalid code. Try again.');
                    }
                });

                // ── Show / regenerate recovery codes ──────────────────────────────────

                /* document.getElementById('btn_show_recovery').addEventListener('click', async function () {
                    const wrap = document.getElementById('tfa_recovery_codes');
                    if (wrap.style.display === '') {
                        wrap.style.display = 'none';
                        this.textContent = 'Show / Regenerate Codes';
                        return;
                    }

                    const data = await apiFetch('/user/two-factor/recovery-codes', 'POST');
                    if (data.success) {
                        renderRecoveryCodes(data.recovery_codes);
                        wrap.style.display = '';
                        this.textContent = 'Hide Codes';
                    } else {
                        alert(data.message);
                    }
                });

                function renderRecoveryCodes(codes) {
                    const wrap = document.getElementById('tfa_recovery_codes');
                    wrap.innerHTML = '<ul class="tfa_recovery_list">'
                        + codes.map(c => `<li><code>${c}</code></li>`).join('')
                        + '</ul>';
                } */

                // ── Disable 2FA ────────────────────────────────────────────────────────

                disable2FAButton.addEventListener('click', function () {
                    document.getElementById('tfa_disable_form').style.display = '';
                    this.style.display = 'none';
                });

                document.getElementById('btn_cancel_disable').addEventListener('click', function () {
                    document.getElementById('tfa_disable_form').style.display = 'none';
                    disable2FAButton.style.display = '';
                    document.getElementById('tfa_disable_password').value = '';
                    document.getElementById('tfa_disable_notices').innerHTML = '';
                });

                document.getElementById('btn_confirm_disable').addEventListener('click', async function () {
                    const password = document.getElementById('tfa_disable_password').value;
                    if (! password) {
                        notice('tfa_disable_notices', 'Please enter your password.');
                        return;
                    }

                    const data = await apiFetch('/user/two-factor/disable', 'POST', { password });

                    if (data.success) {
                        document.getElementById('tfa_disable_form').style.display = 'none';
                        document.getElementById('tfa_disable_password').value = '';
                        setState('disabled');
                    } else {
                        notice('tfa_disable_notices', data.message ?? 'Incorrect password.');
                    }
                });

            });
        </script>

    @endif
@endsection