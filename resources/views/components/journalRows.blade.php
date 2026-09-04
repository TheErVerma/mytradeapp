 @php
    use App\Services\TradeService;
    use App\Services\OptionService;

    $dis_cols = OptionService::getOption('journal_columns');
    $org_cols = TradeService::getJournalColumns();
@endphp
@if(is_array($all_trades) && count($all_trades) >= 1)
    @php
        $has_inline_actions = isset($no_actions) ? !$no_actions : true;
        $td_cnt = 1;
    @endphp
    @foreach ($all_trades as $trade_item)
        @php
            $tred_classes = [];
            if (isset($trade_item['trd_action'])) {
                $tred_classes[] = strtolower($trade_item['trd_action']);
            }
            if($trade_item['trd_exit_price'] == 0){
                $tred_classes[] = 'open';
            }else{
                $tred_classes[] = 'closed';
            }

            $trd_type = isset($trade_item['trd_type']) ? $trade_item['trd_type'] : 'Cash';
            $row_id = $trade_item['id'];
            $row_counter = $trade_item['counter'];
            $instrument = $trade_item['instrument'];
            $inst_type = $instrument && isset($instrument['underlying_type']) ? (in_array($instrument['underlying_type'], ['EQUITY']) ? $instrument['instrument_type'] : $instrument['underlying_type']) : $instrument['instrument_type'];
            $shares = $trade_item['trd_shares'];
            $lot_size = $trade_item['trd_lot'];
            $lot_size = $lot_size <= 0 ? 1 : $lot_size;

            $entry_prc = $trade_item['trd_price'];
            $exit_prc = $trade_item['trd_exit_price'];
            $charges_prc = $trade_item['trd_charges_amount'];
            $qty_multiplier = $instrument['qty_multiplier'];


            $lot_size_val = isset($trade_item['trd_shares']) ? $trade_item['trd_shares'] : 1;
            if ($trd_type != 'Cash') {
                $lot_size_val = ((isset($instrument['lot_size']) && $qty_multiplier <= 1 ? $instrument['lot_size'] : 1) * $lot_size);
            }

            $lot_size_val *= $qty_multiplier;

            $pnl_val = (($exit_prc - $entry_prc) * $lot_size_val) - $charges_prc;
            if ($trade_item['trd_action'] == 'Short') {
                $pnl_val = (($entry_prc - $exit_prc) * $lot_size_val) - $charges_prc;
            }


            $pnl_status = $pnl_val < 0 ? 'loss' : 'profit';
        @endphp
        <tr class="@php echo implode(' ', $tred_classes); @endphp ">
            
            @if($has_inline_actions)
                <td class="trade_b_check w-15 pr-0!" tabindex="-1">
                    <label class="hb-checkbox size-lg" for="rowSelectChk-{{ $row_id }}">
                        <span><input type="checkbox" id="rowSelectChk-{{ $row_id }}" value="{{ $row_id }}"></span>
                    </label>
                </td>
            @endif

            @if(!empty($org_cols))
                @foreach($org_cols as $org_col)
                    @php 
                    $col_id = $org_col['id'];
                    if(in_array($col_id, $dis_cols)){
                        continue;
                    }
                    @endphp

                    @switch ($col_id)
                        @case ('s_no')
                            <td class="trade_b_id">{{ $row_counter }}</td>
                            @break
                        @case ('instrument')
                            <td class="trade_b_symbol">{{ $trade_item['trd_symbol'] }}</td>
                            @break
                        @case ('type')
                            <td class="trade_b_action {{ ($trade_item['trd_action'])[0] == "L" ? 'long' : 'short' }}">
                                <span class="table-tag">
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
                                        <circle cx="4" cy="4" r="2.5" fill="currentColor" stroke="currentColor">
                                        </circle>
                                    </svg>
                                    {{ ($trade_item['trd_action'])[0] }}
                                </span>
                            </td>
                            @break
                        @case ('date')
                            <td class="trade_b_date">{{ date('F d D, Y', strtotime($trade_item['trd_date'])) }}</td>
                            @break
                        @case ('qty')
                            <td class="trade_b_qty">{{ $lot_size_val }}</td>
                            @break
                        @case ('product')
                            <td class="trade_b_type">{{ $inst_type }}</td>
                            @break
                        @case ('entry_price')
                            <td class="trade_b_price">{{ Number::currency(floatval($trade_item['trd_price']), in: $currency) }}</td>
                            @break
                        @case ('exit_price')
                            <td class="trade_b_exit_price">{{ Number::currency(floatval($trade_item['trd_exit_price']), in: $currency) }}</td>
                            @break
                        @case ('p_l')
                        <td class="trade_b_pnl {{ floatval($pnl_val) < 0 ? 'loss' : 'profit' }}">
                            <div class="flex gap-1.5 items-center">

                                <span class="text-success-primary font-medium">
                                    {{ $trade_item['trd_exit_price'] > 0 ? Number::currency(floatval($pnl_val), in: $currency) : '--' }}
                                </span>

                                <div class="tooltip-wrap {{ $charges_prc <= 0 ? 'hide' : '' }}">

                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="size-3.5">
                                        <path
                                            d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3m.08 4h.01M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10Z">
                                        </path>
                                    </svg>

                                    <div class="tooltip-popup">
                                        <div
                                            class="z-50 flex max-w-xs flex-col items-start gap-1 rounded-lg bg-primary-solid px-3 shadow-xs will-change-transform py-2">
                                            <span class="text-xs font-semibold text-white">Charges:
                                                -{{ Number::currency(floatval($charges_prc), in: $currency) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                            @break
                        @default
                            @break
                    @endswitch

                @endforeach
            @endif
            

            @if($has_inline_actions)
                <td class="trade_b_actions">
                    <div class="flex justify-end gap-0.5">
                        <button class="action-icons icon_btn trash" data_id="{{ $trade_item['id'] }}">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-icon="true">
                                <path
                                    d="M16 6v-.8c0-1.12 0-1.68-.218-2.108a2 2 0 0 0-.874-.874C14.48 2 13.92 2 12.8 2h-1.6c-1.12 0-1.68 0-2.108.218a2 2 0 0 0-.874.874C8 3.52 8 4.08 8 5.2V6m2 5.5v5m4-5v5M3 6h18m-2 0v11.2c0 1.68 0 2.52-.327 3.162a3 3 0 0 1-1.311 1.311C16.72 22 15.88 22 14.2 22H9.8c-1.68 0-2.52 0-3.162-.327a3 3 0 0 1-1.311-1.311C5 19.72 5 18.88 5 17.2V6">
                                </path>
                            </svg>
                        </button>

                        <button class="action-icons icon_btn edit" data_id="{{ $trade_item['id'] }}">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-icon="true">
                                <path
                                    d="M2.876 18.116c.046-.414.069-.62.131-.814a2 2 0 0 1 .234-.485c.111-.17.259-.317.553-.61L17 3a2.828 2.828 0 1 1 4 4L7.794 20.206c-.294.294-.442.442-.611.553a2 2 0 0 1-.485.233c-.193.063-.4.086-.814.132L2.5 21.5l.376-3.384Z">
                                </path>
                            </svg>
                        </button>

                    </div>
                </td>
            @endif
        </tr>
        @php
            $td_cnt++;
        @endphp
    @endforeach
@endif