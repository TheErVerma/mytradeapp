<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dummy Email Template</title>
</head>
<body style="background-color: #f4f4f4; margin: 0; padding: 0; font-family: Arial, sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 40px 0;">
    <tr>
      <td align="center">
        <!-- Email Container -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
          
          <!-- Header -->
          <tr>
            <td align="center" bgcolor="#4f6bff" style="padding: 40px 20px;">
              <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Password Changed</h1>
            </td>
          </tr>

          <!-- Body Content -->
          <tr>
            <td style="padding: 30px; color: #333333; line-height: 1.6;">
              <h2 style="margin-top: 0; color: #2c3e50;">Hi there, {{ $name }}</h2>
              <p style="margin-bottom: 20px;">Your password for trade has been updated, if you didn't make this changes please ping the support.</p>
              
              <p style="margin-top: 20px; margin-bottom: 0;">If you have any questions, feel free to reach out to our support team. We're here to help!</p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td bgcolor="#ecf0f1" style="padding: 20px; text-align: center; color: #7f8c8d; font-size: 12px;">
              <p style="margin: 0;">&copy; 2026 TradeApp. All rights reserved.</p>
              <!-- <p style="margin: 5px 0 0;"><a href="#" style="color: #4f6bff; text-decoration: none;">Unsubscribe</a></p> -->
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
