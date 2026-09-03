@if(is_array($broker_data) && !empty($broker_data))
    @foreach ($broker_data as $key => $broker_item)
        <label class="border border-secondary cursor-pointer flex flex-col gap-0.5 hover:bg-primary_hover p-4 rounded-xl z-10 hb-checkbox" for="slctTrdEntry_{{ $key }}">
            <div class="flex flex-row items-center gap-2">
                <span style="margin-top: 0px;">
                    <input type="checkbox" id="slctTrdEntry_{{ $key }}" name="slctTrdEntry[]" value="{{ $broker_item['trd_symbol_key'] }}">
                </span> 
                <div class="text-md text-primary">{{ $broker_item['trd_symbol'] }}</div>
            </div>
            <div class="text-sm text-fg-quaternary">{{ $broker_item['instrument']['name'] }}</div>
        </label>
    @endforeach
@endif