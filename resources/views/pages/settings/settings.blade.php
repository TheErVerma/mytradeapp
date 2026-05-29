@extends('../layout/base')

@section('content')

@php
$user = Auth::user();

$countries = [
    'INR' => 'India (₹)',
    'USD' => 'United States ($)',
    'GBP' => 'United Kingdom (£)'
];
@endphp
    <div class="main_settings_wrap">
        <div class="main_settings_inner">

            <div class="main_set_card">
                <h3>Preferences</h3>
                <p>Customize your trading experience. All trades are automatically linked to your ledger for comprehensive
                    financial tracking.</p>

                <form action="" id="main_set_preference_form">
                    <input type="hidden" name="user_id" value="{{ $user->id }}"/>
                    <div class="main_set_fields">
                        <div class="main_set_field">
                            <label for="default_country">Default Country</label>
                            <select name="default_country" id="default_country">
                                @foreach ($countries as $country_code => $countrty)
                                    <option value="{{ $country_code }}" @php echo $country_code == $user->default_country ? 'selected' : ''; @endphp >{{ $countrty }}</option>
                                @endforeach
                            </select>
                            <span class="field_bmt_text">This will be used throughout the app for all monetary
                                values.</span>
                        </div>
                        <div class="main_set_field">
                            <label for="initial_balance">Initial Account Balance</label>
                            <input type="text" name="initial_balance" id="initial_balance" placeholder="e.g. $2,000.00" value="{{ $user->initial_balance }}"/>
                            <span class="field_bmt_text">Your account balance when you started using the system. This is
                                used as the starting point for all financial calculations.</span>
                        </div>

                        <div class="form_notices"></div>
                        <div class="main_set_actions">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="main_set_card">
                <h3>Danger Zone</h3>
                <p>Security settings and irreversible account actions</p>

                <div class="main_sub_sets">
                    <div class="main_sub_set">
                        <div class="main_sub_set_inner">
                            <h4>Clear All Trade Data</h4>
                            <p>This will permanently delete all your trade records. This action cannot be undone.</p>
                            <button type="button" class="btn btn-danger remove_all_trade_data">Clear Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection