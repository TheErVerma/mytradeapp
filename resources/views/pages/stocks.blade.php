@extends('../layout/base')

@section('content')


    <div class="stocks_wrapper">
        <h1>List a Stock</h1>
        <p>Add a stock to your library by entering its market details, trading specifications, and company information. These details will be available when creating and managing trades.</p>
        <div class="stocks_inner">
            <form action="" id="add_stocks_form">
                @csrf
                <div class="form_fields">

                    <!-- Basic Information -->
                    <div class="form_field_group">
                        <div class="form_field">
                            <label for="symbol">Symbol</label>
                            <input type="text" name="symbol" id="symbol" placeholder="e.g. RELIANCE" required />
                        </div>

                        <div class="form_field">
                            <label for="title">Company Name</label>
                            <input type="text" name="title" id="title" placeholder="e.g. Reliance Industries Ltd."
                                required />
                        </div>
                    </div>

                    <!-- Market Details -->
                    <div class="form_field_group">
                        <div class="form_field">
                            <label for="exchange">Exchange</label>
                            <select name="exchange" id="exchange" required>
                                <option value="">Select Exchange</option>
                                <option value="NSE">NSE</option>
                                <option value="BSE">BSE</option>
                            </select>
                        </div>

                        <div class="form_field">
                            <label for="instrument_type">Instrument Type</label>
                            <select name="instrument_type" id="instrument_type" required>
                                <option value="">Select Type</option>
                                <option value="Equity">Equity</option>
                                <option value="ETF">ETF</option>
                                <option value="Index">Index</option>
                                <option value="Commodity">Commodity</option>
                                <option value="Currency">Currency</option>
                            </select>
                        </div>
                    </div>

                    <!-- Classification -->
                    <div class="form_field_group">
                        <div class="form_field">
                            <label for="series">Series</label>
                            <input type="text" name="series" id="series" placeholder="EQ" />
                        </div>

                        <div class="form_field">
                            <label for="isin">ISIN</label>
                            <input type="text" name="isin" id="isin" placeholder="INE002A01018" />
                        </div>
                    </div>

                    <!-- Sector -->
                    <div class="form_field_group">
                        <div class="form_field">
                            <label for="sector">Sector</label>
                            <input type="text" name="sector" id="sector" placeholder="Financial Services" />
                        </div>

                        <div class="form_field">
                            <label for="industry">Industry</label>
                            <input type="text" name="industry" id="industry" placeholder="Private Banks" />
                        </div>
                    </div>

                    <!-- Trading Details -->
                    <div class="form_field_group">
                        <div class="form_field">
                            <label for="lot_size">Lot Size</label>
                            <input type="number" name="lot_size" id="lot_size" placeholder="1" min="1" />
                        </div>

                        <div class="form_field">
                            <label for="tick_size">Tick Size</label>
                            <input type="number" step="0.01" name="tick_size" id="tick_size" placeholder="0.05" />
                        </div>

                        <div class="form_field">
                            <label for="face_value">Face Value</label>
                            <input type="number" step="0.01" name="face_value" id="face_value" placeholder="10.00" />
                        </div>
                    </div>

                    <!-- Website -->
                    <div class="form_field">
                        <label for="website">Website</label>
                        <input type="url" name="website" id="website" placeholder="https://www.company.com" />
                    </div>

                    <!-- Logo -->
                    <div class="form_field">
                        <label for="logo">Company Logo</label>

                        <div class="logo-preview"></div>

                        <label class="dropzone" for="logo">
                            <input type="file" name="logo" id="logo"
                                accept="image/png,image/jpeg,image/webp,image/svg+xml" />

                            <span class="icon">
                                <!-- upload icon -->
                            </span>

                            <h4>Upload Logo</h4>
                            <p>PNG, JPG, SVG or WebP (Max 2MB)</p>
                        </label>
                    </div>

                    <!-- Description -->
                    <div class="form_field">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="5"
                            placeholder="Brief company description..."></textarea>
                    </div>

                    <!-- Settings -->
                    <div class="form_field_group">

                        <div class="form_field toggle">
                            <div class="form_field_label">Status</div>

                            <div class="form_field togglebtn">
                                <label for="is_active" class="positive">
                                    <span class="option_1">Active</span>
                                    <span class="option_2">Inactive</span>
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked />
                                </label>
                            </div>
                        </div>

                        <div class="form_field">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" value="0" />
                        </div>

                    </div>

                </div>
                <div class="form_action_btns">
                    <button type="button" class="btn btn-md btn-secondary">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-md btn-primary">
                        <span class="text">Save Stock</span>
                        <span class="loader">Please wait...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection