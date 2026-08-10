@extends('../layout/base')

@section('content')
    <div class="full_width_wrap">
        @php
            $trad_actions = array_column($all_trades, 'trd_action');
            $trdActnCnt = array_count_values($trad_actions);
            $trdLong = isset($trdActnCnt['Long']) ? $trdActnCnt['Long'] : 0;
            $trdShort = isset($trdActnCnt['Short']) ? $trdActnCnt['Short'] : 0;
            $trdAllCnt = $trdLong + $trdShort;


        @endphp
        <div class="live_share_head">
            <h1>Shared Journal</h1>
            <p>You’re viewing {{ $user ? $user->name : 'Unknown' }}’s live trading journal. This is a read-only view that displays the latest shared trade information in real time. Access to this page is temporary and will expire automatically.</p>
            <ul>
                <li><strong>Trader:</strong> {{ $user ? $user->name : 'Unknown' }}</li>
                <li><strong>Expires in:</strong> <span id="liveShareCountdown" data_countto="{{ $expiry_time }}">--</span></li>
            </ul>
        </div>
        <div class="trades_table_wrapper">
            <div class="trades_table_inner">
                <div class="trades_table_filter_top">
                    <div class="trades_search_wrap">
                        <div class="trades_date_filter">
                            <div class="trades_search_inp">
                                <span class="trades_search_inp_icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="Interface / Search_Magnifying_Glass">
                                            <path id="Vector"
                                                d="M15 15L21 21M10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10C17 13.866 13.866 17 10 17Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </span>
                                <input type="search" name="trade_search" id="trade_search" placeholder="Search trades...">
                            </div>
                            <input type="text" class="datepicker" name="trade_date_from" id="trade_date_from"
                                date_type="from" placeholder="From" />
                            <input type="text" class="datepicker" name="trade_date_to" id="trade_date_to" date_type="to"
                                placeholder="To" />
                        </div>
                    </div>
                </div>
                <div class="trades_table_filter_btm">
                    <ul>
                        <li data_type="all" class="active">All Trades (<span class="count">{{ $trdAllCnt }}</span>)</li>
                        <li data_type="long">Long (<span class="count">{{ $trdLong }}</span>)</li>
                        <li data_type="short">Short (<span class="count">{{ $trdShort }}</span>)</li>
                    </ul>
                    <div class="trades_table_actions">
                        <button type="button" class="btn" id="share_trade_screenshot">
                            <span class="icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M5 10.2V14.533C5.00423 15.4569 5.3754 16.3413 6.0318 16.9915C6.68821 17.6418 7.57608 18.0045 8.5 18H15.5C16.4239 18.0045 17.3118 17.6418 17.9682 16.9915C18.6246 16.3413 18.9958 15.4569 19 14.533V10.2C18.9958 9.27608 18.6246 8.39169 17.9682 7.74148C17.3118 7.09126 16.4239 6.72849 15.5 6.73301C15.0147 6.66864 14.6001 6.3515 14.411 5.90001C14.1009 5.34285 13.5126 4.99815 12.875 5.00001H11.125C10.4874 4.99815 9.89908 5.34285 9.589 5.90001C9.39986 6.3515 8.98526 6.66864 8.5 6.73301C7.57608 6.72849 6.68821 7.09126 6.0318 7.74148C5.3754 8.39169 5.00423 9.27608 5 10.2Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M12 14.533C10.8059 14.5214 9.84617 13.546 9.85405 12.3518C9.86193 11.1576 10.8344 10.1949 12.0286 10.1991C13.2228 10.2033 14.1885 11.1728 14.188 12.367C14.1851 12.9444 13.9529 13.4969 13.5426 13.9032C13.1323 14.3094 12.5774 14.5359 12 14.533Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            Share Screenshot
                        </button>
                    </div>
                </div>

                <div class="no_trades_wrapper" @if(is_array($all_trades) && count($all_trades) >= 1)) style="display:none;"
                @endif>
                    <div class="no_trades_wrapper_inner">
                        <h4>No trades match your criteria</h4>
                        <p>Try adjusting your search or filters to see more results</p>
                    </div>
                </div>

                <table class="main_trades_table" @if(!is_array($all_trades) || (is_array($all_trades) && count($all_trades) <= 0)) style="display:none;" @endif>
                    <thead>
                        <tr>
                            <th class="trade_h_id">ID</th>
                            <!-- <th>Market Name</th> -->
                            <th class="trade_h_symbol">Symbol</th>
                            <th class="trade_h_action">Action</th>
                            <th class="trade_h_date">Date</th>
                            <th class="trade_h_shares">Shares</th>
                            <th class="trade_h_lot">Lot</th>
                            <th class="trade_h_price">Price</th>
                            <th class="trade_h_exit_price">Exit Price</th>
                            <th class="trade_h_pnl">P&L</th>
                            <!-- <th>Commissions</th>
                                <th>Fees</th> -->
                            <th class="trade_h_actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(is_array($all_trades) && count($all_trades) >= 1)
                            @php
                                $td_cnt = 1;
                            @endphp
                            @foreach ($all_trades as $trade_item)
                                @php
                                    $tred_classes = [];
                                    if (isset($trade_item['trd_action'])) {
                                        $tred_classes[] = strtolower($trade_item['trd_action']);
                                    }

                                    $shares = $trade_item['trd_shares'];
                                    $lot_size = $trade_item['trd_lot'];

                                    $entry_prc = $trade_item['trd_price'];
                                    $exit_prc = $trade_item['trd_exit_price'];
                                    $charges_prc = $trade_item['trd_charges_amount'];
                                    $pnl_val = ($exit_prc - $entry_prc) - $charges_prc;
                                    $pnl_status = $pnl_val < 0 ? 'loss' : 'profit';
                                @endphp
                                <tr class="@php echo implode(' ', $tred_classes); @endphp ">
                                    <td class="trade_b_id">{{ $td_cnt/*$trade_item['id']*/ }}</td>
                                    <td class="trade_b_symbol"><span
                                            data-href="/journal/{{ $trade_item['id'] }}">{{ $trade_item['trd_symbol'] }}</span></td>
                                    <td class="trade_b_action"><span>{{ $trade_item['trd_action'] }}</span></td>
                                    <td class="trade_b_date">{{ date('F d, Y', strtotime($trade_item['trd_date'])) }}</td>
                                    <td class="trade_b_shares">{{ $trade_item['trd_type'] == 'Cash' ? $shares : '--' }}</td>
                                    <td class="trade_b_lot">{{ $trade_item['trd_type'] == 'F&O' ? $lot_size : '--' }}</td>
                                    <td class="trade_b_price">
                                        {{ Number::currency(floatval($trade_item['trd_price']), in: $currency) }}</td>
                                    <td class="trade_b_exit_price">
                                        {{ Number::currency(floatval($trade_item['trd_exit_price']), in: $currency) }}</td>
                                    <td class="trade_b_pnl {{ $pnl_status }}">
                                        {{ Number::currency(floatval($pnl_val), in: $currency) }}
                                        <span class="pnl_info">
                                            <svg width="14px" height="14px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 7C12.5523 7 13 7.44772 13 8V13C13 13.5523 12.5523 14 12 14C11.4477 14 11 13.5523 11 13V8C11 7.44772 11.4477 7 12 7Z" />
                                                <path
                                                    d="M12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12Z" />
                                            </svg>
                                            <div class="pnl_sub_info">Charges:
                                                -{{ Number::currency(floatval($charges_prc), in: $currency) }}</div>
                                        </span>
                                    </td>
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
                                                    <path d="M14 12V17" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" />
                                                    <path d="M10 12V17" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" />
                                                </svg>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $td_cnt++;
                                @endphp
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection