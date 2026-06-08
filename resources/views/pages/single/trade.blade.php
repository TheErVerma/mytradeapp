@php
    use Illuminate\Support\Number;
@endphp
@extends('../layout/base')


@section('content')
    <div class="single_trade_wrap">

        <div class="single_trade_head">
            <div class="head_prev">
                <a href="/journal" class="icon_btn">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.66088 8.53078C9.95402 8.23813 9.95442 7.76326 9.66178 7.47012C9.36913 7.17698 8.89426 7.17658 8.60112 7.46922L9.66088 8.53078ZM4.47012 11.5932C4.17698 11.8859 4.17658 12.3607 4.46922 12.6539C4.76187 12.947 5.23674 12.9474 5.52988 12.6548L4.47012 11.5932ZM5.51318 11.5771C5.21111 11.2936 4.73648 11.3088 4.45306 11.6108C4.16964 11.9129 4.18475 12.3875 4.48682 12.6709L5.51318 11.5771ZM8.61782 16.5469C8.91989 16.8304 9.39452 16.8152 9.67794 16.5132C9.96136 16.2111 9.94625 15.7365 9.64418 15.4531L8.61782 16.5469ZM5 11.374C4.58579 11.374 4.25 11.7098 4.25 12.124C4.25 12.5382 4.58579 12.874 5 12.874V11.374ZM15.37 12.124V12.874L15.3723 12.874L15.37 12.124ZM17.9326 13.1766L18.4614 12.6447V12.6447L17.9326 13.1766ZM18.25 15.7351C18.2511 16.1493 18.5879 16.4841 19.0021 16.483C19.4163 16.4819 19.7511 16.1451 19.75 15.7309L18.25 15.7351ZM8.60112 7.46922L4.47012 11.5932L5.52988 12.6548L9.66088 8.53078L8.60112 7.46922ZM4.48682 12.6709L8.61782 16.5469L9.64418 15.4531L5.51318 11.5771L4.48682 12.6709ZM5 12.874H15.37V11.374H5V12.874ZM15.3723 12.874C16.1333 12.8717 16.8641 13.1718 17.4038 13.7084L18.4614 12.6447C17.6395 11.8276 16.5267 11.3705 15.3677 11.374L15.3723 12.874ZM17.4038 13.7084C17.9435 14.245 18.2479 14.974 18.25 15.7351L19.75 15.7309C19.7468 14.572 19.2833 13.4618 18.4614 12.6447L17.4038 13.7084Z"
                            fill="currentColor" />
                    </svg>
                </a>
            </div>
            <div class="head_content">
                <h1>{{ $trade['trd_symbol'] }}</h1>
                <ul class="single_trade_tags">
                    @php
                    if($trade['trd_action'] == 'Buy'){
                        echo sprintf('<li>%s</li>', 'Long');
                    }else if($trade['trd_action'] == 'Sell'){
                        echo sprintf('<li>%s</li>', 'Short');
                    }
                    @endphp
                    
                    <li>Open</li>
                </ul>
            </div>
            <div class="head_end">
                <button type="button" class="btn btn-secondary">Edit</button>
            </div>
        </div>

        @php
            // Array
            // (
            //     [id] => 1
            //     [trd_symbol] => RELIANCE
            //     [trd_action] => Buy
            //     [trd_date] => 2026-04-22
            //     [trd_time] => 19:52:00
            //     [trd_shares] => 0
            //     [trd_price] => 123.00
            //     [created_at] => 2026-05-29T12:22:41.000000Z
            //     [updated_at] => 2026-05-29T12:22:41.000000Z
            //     [user_id] => 1
            //     [trd_lot] => 123
            //     [trd_type] => F&O
            //     [trd_screenshots] => a:0:{}
            // )

            $trade_id = $trade['id'];

            $trade_ss = isset($trade['trd_screenshots']) ? unserialize($trade['trd_screenshots']) : [];

            $trd_date = $trade['trd_date'];
            $trd_time = $trade['trd_time'];

            $tradeDateTime = new DateTime($trd_date . ' ' . $trd_time);
            $now = new DateTime();

            $interval = $tradeDateTime->diff($now);
        @endphp

        <div class="single_trade_body">


            <div class="single_trade_tabs">
                <div class="single_trade_tab active" tab_id="overview">Overview</div>
                <div class="single_trade_tab" tab_id="chart">Chart</div>
                <div class="single_trade_tab" tab_id="journal">Journal</div>
                <div class="single_trade_tab" tab_id="analysis">Analysis</div>
            </div>

            <div class="single_trtb_cnt_wrap">

                <div class="single_trtb_cnt active" cnt_id="overview">
                    <div class="sngl_trd_snapshot">
                        <h4>Trade Snapshot</h4>
                        <div class="sngl_trd_snapshot_inner">

                            <div class="sngltrd_snp_lft">
                                <div class="sngltrd_tbl">
                                    <div class="sngltrd_tbl_title">Entry Date</div>
                                    <div class="sngltrd_tbl_value">{{ date('F d, Y', strtotime($trade['trd_date'])) }}</div>
                                </div>
                                <div class="sngltrd_tbl">
                                    <div class="sngltrd_tbl_title">Entry Time</div>
                                    <div class="sngltrd_tbl_value">{{ date('h:m A', strtotime($trade['trd_time'])) }}</div>
                                </div>
                                <div class="sngltrd_tbl">
                                    <div class="sngltrd_tbl_title">Duration</div>
                                    <div class="sngltrd_tbl_value">{{ $interval->format('%ad %hh %im') }}</div>
                                </div>
                                <div class="sngltrd_tbl">
                                    <div class="sngltrd_tbl_title">Quantity</div>
                                    <div class="sngltrd_tbl_value">{{ $trade['trd_lot'] ?? $trade['trd_shares'] }}</div>
                                </div>
                            </div>

                            <div class="sngltrd_snp_rgt">
                                <div class="sngltrd_tbl">
                                    <div class="sngltrd_tbl_title">Entry</div>
                                    <div class="sngltrd_tbl_value">{{ Number::currency($trade['trd_price'], $currency) }}</div>
                                </div>
                                <span class="line_separator"></span>
                                <div class="sngltrd_tbl">
                                    <div class="sngltrd_tbl_title">Position Value</div>
                                    <div class="sngltrd_tbl_value">{{ Number::currency($trade['trd_price'], $currency) }}</div>
                                </div>
                                <div class="sngltrd_tbl">
                                    @php
                                    $sh_qty = $trade['trd_lot'] ?? $trade['trd_shares'];
                                    $sh_prc = $trade['trd_price'];
                                    $sh_per = 15;
                                    $sh_mrgn_blk = ($sh_qty * $sh_prc) * 0.15;
                                    @endphp
                                    <div class="sngltrd_tbl_title">Margin Blocked</div>
                                    <div class="sngltrd_tbl_value">{{ Number::currency($sh_mrgn_blk, $currency) }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="single_trtb_cnt" cnt_id="chart">Chart</div>
                <div class="single_trtb_cnt" cnt_id="journal">
                    <div class="journal-content">
                        @if(!empty($trade_notes = $trade['notes']))
                        <div class="journal-notes">
                            <h3>Trade Journal</h3>
                            <form id="notesForm">
                                <input type="hidden" name="trade_id" value="{{ $trade_id }}" />
                                <button class="btn btn-primary" type="Submit" id="save-notes">Save Notes</button>
                                <textarea name="journal_notes" id="journal_notes" cols="30" rows="10">{{ $trade_notes }}</textarea>
                            </form>
                        </div>
                        @endif

                        <div class="screenshot-gallery">
                            <form id="uploadForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="trade_id" value="{{ $trade_id }}" />
                                <input type="file" id="imageInput" name="image" multiple hidden>
                                <button class="btn btn-primary" type="button" id="uploadBtn">Upload Image</button>
                            </form>
                            @if(!empty($trade_ss))
                                <div class="image_gallery">
                                    @foreach ($trade_ss as $trade_ss_itm)
                                        <div class="screenshot-thumb" >
                                            <img src="{{ $trade_ss_itm }}" data-tid="{{ $trade_id }}" />
                                            <div class="screenshot-actions">
                                                <button class="screenshot-view" data-fancybox="gallery" data-src="{{ $trade_ss_itm }}">
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 83.78" style="enable-background:new 0 0 122.88 83.78" xml:space="preserve"><g><path d="M95.73,10.81c10.53,7.09,19.6,17.37,26.48,29.86l0.67,1.22l-0.67,1.21c-6.88,12.49-15.96,22.77-26.48,29.86 C85.46,79.88,73.8,83.78,61.44,83.78c-12.36,0-24.02-3.9-34.28-10.81C16.62,65.87,7.55,55.59,0.67,43.1L0,41.89l0.67-1.22 c6.88-12.49,15.95-22.77,26.48-29.86C37.42,3.9,49.08,0,61.44,0C73.8,0,85.45,3.9,95.73,10.81L95.73,10.81z M60.79,22.17l4.08,0.39 c-1.45,2.18-2.31,4.82-2.31,7.67c0,7.48,5.86,13.54,13.1,13.54c2.32,0,4.5-0.62,6.39-1.72c0.03,0.47,0.05,0.94,0.05,1.42 c0,11.77-9.54,21.31-21.31,21.31c-11.77,0-21.31-9.54-21.31-21.31C39.48,31.71,49.02,22.17,60.79,22.17L60.79,22.17L60.79,22.17z M109,41.89c-5.5-9.66-12.61-17.6-20.79-23.11c-8.05-5.42-17.15-8.48-26.77-8.48c-9.61,0-18.71,3.06-26.76,8.48 c-8.18,5.51-15.29,13.45-20.8,23.11c5.5,9.66,12.62,17.6,20.8,23.1c8.05,5.42,17.15,8.48,26.76,8.48c9.62,0,18.71-3.06,26.77-8.48 C96.39,59.49,103.5,51.55,109,41.89L109,41.89z"/></g></svg>
                                                </button>
                                                <button class="screenshot-delete">
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="109.484px" height="122.88px" viewBox="0 0 109.484 122.88" enable-background="new 0 0 109.484 122.88" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M2.347,9.633h38.297V3.76c0-2.068,1.689-3.76,3.76-3.76h21.144 c2.07,0,3.76,1.691,3.76,3.76v5.874h37.83c1.293,0,2.347,1.057,2.347,2.349v11.514H0V11.982C0,10.69,1.055,9.633,2.347,9.633 L2.347,9.633z M8.69,29.605h92.921c1.937,0,3.696,1.599,3.521,3.524l-7.864,86.229c-0.174,1.926-1.59,3.521-3.523,3.521h-77.3 c-1.934,0-3.352-1.592-3.524-3.521L5.166,33.129C4.994,31.197,6.751,29.605,8.69,29.605L8.69,29.605z M69.077,42.998h9.866v65.314 h-9.866V42.998L69.077,42.998z M30.072,42.998h9.867v65.314h-9.867V42.998L30.072,42.998z M49.572,42.998h9.869v65.314h-9.869 V42.998L49.572,42.998z"/></g></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="single_trtb_cnt" cnt_id="analysis">Analysis</div>
            </div>



        </div>
    </div>
@endsection