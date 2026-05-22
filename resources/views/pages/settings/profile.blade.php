@extends('../../layout/base')


@section('content')

    @php
        $user = Auth::user();
    @endphp

    @if(isset($user))

        <div class="profile_settings_wrap">
            <div class="profile_settings_inner">

                <div class="prf_set_card_wrapper">
                    <div class="prf_set_card profile_head">
                        <div class="p_h_banner"></div>
                        <div class="profile_image">
                            <img src="" alt="">
                        </div>
                        <div class="profile_user_info">
                            <h4>Jhon Doe</h4>
                            <p>ACCOUNT STATUS: INSTITUTIONAL ELITE</p>
                        </div>
                    </div>

                    <div class="prf_set_card profile_personal_info">
                        <div class="prf_set_head">
                            <span class="icon"></span>
                            <h3>Personal Information</h3>
                        </div>
                        <div class="prf_set_fields">
                            <div class="prf_set_field_group">
                                <div class="prf_set_field">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="first_name" placeholder="Jhon" />
                                </div>
                                <div class="prf_set_field">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" placeholder="Doe" />
                                </div>
                            </div>
                            <div class="prf_set_field_group">
                                <div class="prf_set_field">
                                    <label for="email_address">Email Address</label>
                                    <input type="text" name="email_address" id="email_address" placeholder="Jhon@example.com" />
                                </div>
                                <div class="prf_set_field">
                                    <label for="timezone">Last Name</label>
                                    <input type="text" name="timezone" id="timezone" placeholder="GMT-05:00" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="prf_set_card profile_security">
                        <div class="prf_set_head">
                            <span class="icon"></span>
                            <h3>Security & Privacy</h3>
                        </div>
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
                            <div class="prf_row_set">
                                <div class="prf_rgt">
                                    <span class="title">Two-Factor Authentication (2FA)</span>
                                    <span class="description">Currently active for enhanced security</span>
                                </div>
                                <div class="prf_lft">
                                    <button type="button" class="btn btn-primary">Enable</button>
                                    <button type="button" class="btn btn-secondary">Disable</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
@endsection