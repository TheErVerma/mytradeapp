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
                <h2>{{ Number::currency($net_amount, in: $currency) }}</h2>
                <h5>+{{ Number::currency($net_amount, in: $currency) }}</h5>
            </div>
            @php
                $items = [
                    'net_realized_pnl' => 'Net Realized P&L',
                    'unrealized_pnl' => 'Unrealized P&L',
                    'available_cash' => 'Available Cash',
                    'deployed_capital' => 'Deployed Capital',
                    'total_open_risk_percent' => 'Total Open Risk (127.0%)',
                    'starting_account_balance' => 'Starting Account Balance',
                ];
            @endphp

            <div class="other_dash_amounts">

                @foreach($items as $key => $label)
                    @php
                        $value = $portfolioSummry[$key] ?? 0;
                    @endphp

                    <div class="other_dash_amount_itm {{ $value < 0 ? 'negative' : 'positive' }}">
                        <p>{{ $label }}</p>
                        <h4>{{ Number::currency($value, in: $currency) }}</h4>
                    </div>
                @endforeach

                <div class="other_dash_amount_itm">
                    <p>Total Deposits</p>
                    <h4>--</h4>
                </div>

                <div class="other_dash_amount_itm">
                    <p>Total Withdrawn</p>
                    <h4>--</h4>
                </div>

            </div>

            <div class="dash_amount_bmt_text">
                Returns are shown once deposits are made.
            </div>
        </div>
    </div>
@endsection