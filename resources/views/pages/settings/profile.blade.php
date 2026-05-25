@extends('../../layout/base')


@section('content')

    @php
        $user = Auth::user();
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