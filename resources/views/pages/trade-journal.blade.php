@php
    use Illuminate\Support\Number;
@endphp
@extends('../layout/base')

@section('content')

    @php
        // $all_trades
        $trad_actions = array_column($all_trades, 'trd_action');
        $trdActnCnt = array_count_values($trad_actions);
        $trdLong = isset($trdActnCnt['Buy']) ? $trdActnCnt['Buy'] : 0;
        $trdShort = isset($trdActnCnt['Sell']) ? $trdActnCnt['Sell'] : 0;
        $trdAllCnt = $trdLong + $trdShort;
        $trdActionNm = ['Buy' => 'Long', 'Sell' => 'Short'];
    @endphp

    <div class="trades_table_wrapper">
        <div class="trades_table_inner">
            <div class="trades_table_filter_btm">
                <ul>
                    <li data_type="all" class="active">All Trades ({{ $trdAllCnt }})</li>
                    <li data_type="long">Long ({{ $trdLong }})</li>
                    <li data_type="short">Short ({{ $trdShort }})</li>
                </ul>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="trade_h_id">ID</th>
                        <!-- <th>Market Name</th> -->
                        <th class="trade_h_symbol">Symbol</th>
                        <th class="trade_h_action">Action</th>
                        <th class="trade_h_date">Date</th>
                        <th class="trade_h_time">Time</th>
                        <th class="trade_h_shares">Shares</th>
                        <th class="trade_h_price">Price</th>
                        <!-- <th>Commissions</th>
                            <th>Fees</th> -->
                        <th class="trade_h_actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(is_array($all_trades) && count($all_trades) >= 1)
                        @foreach ($all_trades as $trade_item)
                            @php
                                $tred_classes = [];
                                if (isset($trade_item['trd_action'])) {
                                    $tred_classes[] = strtolower($trade_item['trd_action']);
                                }

                                $shares = $trade_item['trd_shares'];
                                $shares = $shares <= 0 ? $trade_item['trd_lot'] : $shares;
                            @endphp
                            <tr class="@php echo implode(' ', $tred_classes); @endphp ">
                                <td class="trade_b_id">{{ $trade_item['id'] }}</td>
                                <td class="trade_b_symbol"><a href="/journal/{{ $trade_item['id'] }}">{{ $trade_item['trd_symbol'] }}</a></td>
                                <td class="trade_b_action"><span>{{ $trdActionNm[$trade_item['trd_action']] }}</span></td>
                                <td class="trade_b_date">{{ $trade_item['trd_date'] }}</td>
                                <td class="trade_b_time">{{ $trade_item['trd_time'] }}</td>
                                <td class="trade_b_shares">{{ $shares }}</td>
                                <td class="trade_b_price">{{ Number::currency(floatval($trade_item['trd_price']), in:$currency) }}</td>
                                <td class="trade_b_actions">
                                    <div class="trade_action_wrap">
                                        <button type="button" class="icon_btn edit" data_id="{{ $trade_item['id'] }}">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M14.2322 5.76777C15.2085 4.79146 16.7915 4.79146 17.7678 5.76777L18.4749 6.47487C19.4512 7.45118 19.4512 9.0341 18.4749 10.0104L10.3431 18.1421L7.10051 18.1421C6.54822 18.1421 6.1005 17.6944 6.10051 17.1421L6.10051 13.8995L14.2322 5.76777ZM16.3536 7.18198L17.0607 7.88909C17.2559 8.08435 17.2559 8.40093 17.0607 8.59619L16 9.65685L14.5858 8.24264L15.6464 7.18198C15.8417 6.98672 16.1583 6.98672 16.3536 7.18198ZM14.5858 11.0711L9.51472 16.1421L8.10051 16.1421L8.10051 14.7279L13.1716 9.65685L14.5858 11.0711Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </button>
                                        <button type="button" class="icon_btn trash" data_id="{{ $trade_item['id'] }}">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.16565 10.1534C5.07629 8.99181 5.99473 8 7.15975 8H16.8402C18.0053 8 18.9237 8.9918 18.8344 10.1534L18.142 19.1534C18.0619 20.1954 17.193 21 16.1479 21H7.85206C6.80699 21 5.93811 20.1954 5.85795 19.1534L5.16565 10.1534Z"
                                                    stroke="currentColor" stroke-width="2" />
                                                <path d="M19.5 5H4.5" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                                <path d="M10 3C10 2.44772 10.4477 2 11 2H13C13.5523 2 14 2.44772 14 3V5H10V3Z"
                                                    stroke="currentColor" stroke-width="2" />
                                                <path d="M14 12V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                <path d="M10 12V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            </svg>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection