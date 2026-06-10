@extends('../layout/base')

@section('content')


    <div class="analytics_wrapper">
        <div class="analytics_inner">
            <h4>Analytics</h4>

            <ul class="analytics_nav">
                <li>Portfolio</li>
                <li>Performance</li>
                <li>Risk</li>
                <li>Strategy</li>
                <li>Behavior</li>
            </ul>


            <div class="analytics_highlights_wrap">
                
                <div class="analytics_highlight_item">
                    <span class="title">Net Realised P&L</span>
                    <h4 class="item_value">-$2,550.50</h4>
                    <span class="bottom_text">12</span>
                </div>

                <div class="analytics_highlight_item">
                    <span class="title">Profit Factor</span>
                    <h4 class="item_value">-0.16</h4>
                    <span class="bottom_text">Gross P&L split</span>
                </div>

                <div class="analytics_highlight_item">
                    <span class="title">Expectancy</span>
                    <h4 class="item_value">-$39.24</h4>
                    <span class="bottom_text">Per trade average</span>
                </div>

                <div class="analytics_highlight_item">
                    <span class="title">Avg win/loss trade</span>
                    <h4 class="item_value">0.02</h4>
                </div>

            </div>
        </div>
    </div>

@endsection