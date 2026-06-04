@php
    use Illuminate\Support\Number;
@endphp
@extends('../layout/base')

@section('content')

    <div class="main_dash_wrap">
        <div class="main_dash_inner">
            <h4>Account Summary</h4>

            <div class="hightlight_dash_amount">
                <p>Net Account Value</p>
                <h2>{{ Number::currency($net_amount, in:$currency) }}</h2>
                <h5>+{{ Number::currency($net_amount, in:$currency) }}</h5>
            </div>

            @php
            // echo "<pre>";
            // print_r($tradingStats);
            // echo "</pre>";
            @endphp

            <div class="other_dash_amounts">
                <div class="other_dash_amount_itm">
                    <p>Net Realized P&L</p>
                    <h4>{{Number::currency((isset($portfolioSummry['net_realized_pnl']) ? $portfolioSummry['net_realized_pnl'] : 0), in:$currency)}}</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Unrealized P&L</p>
                    <h4>{{Number::currency((isset($portfolioSummry['unrealized_pnl']) ? $portfolioSummry['unrealized_pnl'] : 0), in:$currency)}}</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Available Cash</p>
                    <h4>{{Number::currency((isset($portfolioSummry['available_cash']) ? $portfolioSummry['available_cash'] : 0), in:$currency)}}</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Deployed Capital</p>
                    <h4>{{Number::currency((isset($portfolioSummry['deployed_capital']) ? $portfolioSummry['deployed_capital'] : 0), in:$currency)}}</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Total Open Risk (127.0%)</p>
                    <h4>{{Number::currency((isset($portfolioSummry['total_open_risk_percent']) ? $portfolioSummry['total_open_risk_percent'] : 0), in:$currency)}}</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Total Deposits</p>
                    <h4>--</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Total Withdrawn</p>
                    <h4>--</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Starting Account Balance</p>
                    <h4>{{Number::currency((isset($portfolioSummry['starting_account_balance']) ? $portfolioSummry['starting_account_balance'] : 0), in:$currency)}}</h4>
                </div>
            </div>

            <div class="dash_amount_bmt_text">
                Returns are shown once deposits are made.
            </div>
        </div>
    </div>
@endsection