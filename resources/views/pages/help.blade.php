@extends('../layout/base')

@section('content')

    <div class="help-page">

        <div class="help-header">
            <h1 class="help-title">Help & Support</h1>
            <p class="help-description">
                Welcome to the Help Center. Find answers to common questions and learn how to get the most out of the
                platform.
            </p>
        </div>

        <div class="help-section">
            <h2 class="section-title">Getting Started</h2>

            <div class="help-card">
                <h3 class="card-title">Creating an Account</h3>
                <ol class="help-list">
                    <li>Register using your email address.</li>
                    <li>Verify your email account.</li>
                    <li>Complete your profile information.</li>
                    <li>Start using the platform.</li>
                </ol>
            </div>

            <div class="help-card">
                <h3 class="card-title">Logging In</h3>
                <p>
                    Enter your registered email address and password. If you forget your password,
                    use the <strong>Forgot Password</strong> option on the login page.
                </p>
            </div>
        </div>

        <div class="help-section">
            <h2 class="section-title">Portfolio Management</h2>

            <div class="help-card">
                <h3 class="card-title">Viewing Your Portfolio</h3>
                <p>Your portfolio dashboard provides:</p>
                <ul class="help-list">
                    <li>Current portfolio value</li>
                    <li>Asset allocation overview</li>
                    <li>Profit & Loss (P&amp;L)</li>
                    <li>Trading history</li>
                    <li>Performance insights</li>
                </ul>
            </div>

            <div class="help-card">
                <h3 class="card-title">Managing Holdings</h3>
                <p>You can add, edit, or remove holdings and track their performance over time.</p>
            </div>
        </div>

        <div class="help-section">
            <h2 class="section-title">Trades & Transactions</h2>

            <div class="help-card">
                <h3 class="card-title">Recording a Trade</h3>
                <ol class="help-list">
                    <li>Select the asset you want to trade.</li>
                    <li>Choose Buy or Sell.</li>
                    <li>Enter the trade details.</li>
                    <li>Confirm the transaction.</li>
                </ol>
            </div>

            <div class="help-card">
                <h3 class="card-title">Trade History</h3>
                <p>
                    All completed trades are stored in your account and can be viewed from the
                    Trade History section.
                </p>
            </div>
        </div>

        <div class="help-section">
            <h2 class="section-title">Reports & Analytics</h2>

            <div class="help-card">
                <h3 class="card-title">Performance Reports</h3>
                <p>
                    Access detailed reports to monitor portfolio growth, profit and loss,
                    asset performance, and trading activity.
                </p>
            </div>
        </div>

        <div class="help-section">
            <h2 class="section-title">Notifications</h2>

            <div class="help-card">
                <p>You may receive notifications for:</p>

                <ul class="help-list">
                    <li>Trade confirmations</li>
                    <li>Price alerts</li>
                    <li>Portfolio updates</li>
                    <li>Account activity</li>
                    <li>Feature announcements</li>
                </ul>
            </div>
        </div>

        <div class="help-section">
            <h2 class="section-title">Account Settings</h2>

            <div class="help-card">
                <h3 class="card-title">Profile Settings</h3>
                <p>You can update:</p>

                <ul class="help-list">
                    <li>Name</li>
                    <li>Email address</li>
                    <li>Profile picture</li>
                    <li>Personal preferences</li>
                </ul>
            </div>

            <div class="help-card">
                <h3 class="card-title">Change Password</h3>
                <ol class="help-list">
                    <li>Open Settings.</li>
                    <li>Go to Security.</li>
                    <li>Select Change Password.</li>
                    <li>Enter your current and new password.</li>
                </ol>
            </div>
        </div>

        <div class="help-section">
            <h2 class="section-title">Security Tips</h2>

            <div class="help-card">
                <ul class="help-list">
                    <li>Use a strong password.</li>
                    <li>Do not share your login credentials.</li>
                    <li>Log out from shared devices.</li>
                    <li>Keep your email account secure.</li>
                </ul>
            </div>
        </div>

        <div class="help-section">
            <h2 class="section-title">Frequently Asked Questions</h2>

            <div class="faq-item">
                <h3 class="faq-question">
                    Why is my portfolio value different from live market prices?
                </h3>
                <p class="faq-answer">
                    Portfolio values may be calculated using the latest available market data
                    and could have a slight delay.
                </p>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">
                    Can I edit a trade after saving it?
                </h3>
                <p class="faq-answer">
                    Depending on platform settings, some transactions may be editable while
                    others may be locked for accuracy.
                </p>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">
                    How can I reset my password?
                </h3>
                <p class="faq-answer">
                    Use the Forgot Password option on the login page and follow the instructions
                    sent to your registered email address.
                </p>
            </div>
        </div>

        <div class="help-section">
            <h2 class="section-title">Contact Support</h2>

            <div class="help-card">
                <p>
                    If you need assistance, please contact our support team.
                </p>

                <p>
                    <strong>Email:</strong> support@yourdomain.com
                </p>

                <p>
                    When contacting support, include:
                </p>

                <ul class="help-list">
                    <li>Your account email address</li>
                    <li>Description of the issue</li>
                    <li>Screenshots if applicable</li>
                    <li>Steps to reproduce the problem</li>
                </ul>
            </div>
        </div>

        <!-- <div class="help-footer">
            <p class="disclaimer-text">
                Trading and investing involve risk. Past performance does not guarantee future results.
                Always perform your own research before making financial decisions.
            </p>

            <p class="help-version">
                Version 1.0 • Last Updated June 2026
            </p>
        </div> -->

    </div>
@endsection