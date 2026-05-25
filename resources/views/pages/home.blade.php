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
                <h2>$24,534.71</h2>
                <h5>+$24,534.71</h5>
            </div>

            <div class="other_dash_amounts">
                <div class="other_dash_amount_itm">
                    <p>Net Realized P&L</p>
                    <h4>-$2,867.50</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Unrealized P&L</p>
                    <h4>-$6,632.49</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Available Cash</p>
                    <h4>$0.00</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Deployed Capital</p>
                    <h4>$31,167.20</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Total Open Risk (127.0%)</p>
                    <h4>$31,167.20</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Total Deposits</p>
                    <h4>$0.00</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Total Withdrawn</p>
                    <h4>$0.00</h4>
                </div>
                <div class="other_dash_amount_itm">
                    <p>Starting Account Balance</p>
                    <h4>$500,000.00</h4>
                </div>
            </div>

            <div class="dash_amount_bmt_text">
                Returns are shown once deposits are made.
            </div>
        </div>
    </div>
@endsection