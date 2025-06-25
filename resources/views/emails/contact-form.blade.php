<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <title>New Contact Message</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      color: #333;
    }
    .email-wrapper {
      max-width: 600px;
      margin: 20px auto;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      overflow: hidden;
    }
    .email-header {
      background: linear-gradient(135deg, #007bff, #00c6ff);
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    .email-header h2 {
      margin: 0;
      font-size: 22px;
    }
    .email-body {
      padding: 20px;
    }
    .email-body p {
      font-size: 16px;
      margin: 10px 0;
    }
    .email-body ul {
      padding-left: 20px;
      list-style-type: disc;
    }
    .email-body li {
      font-size: 16px;
      margin-bottom: 8px;
    }
    .email-footer {
      padding: 15px;
      text-align: center;
      font-size: 13px;
      color: #777;
      background-color: #f1f1f1;
    }
    @media (prefers-color-scheme: dark) {
      body {
        background-color: #181818;
        color: #e0e0e0;
      }
      .email-wrapper {
        background: #222;
        color: #e0e0e0;
      }
      .email-body, .email-footer {
        background: #222;
        color: #e0e0e0;
      }
      .email-header {
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        color: #fff;
      }
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="email-header">
      <h2>📬 New Contact Form Submission</h2>
    </div>
    <div class="email-body">
      <p><strong>Contact Details:</strong></p>
      <ul>
        <li><strong>Name:</strong> {{ $data['name'] }}</li>
        <li><strong>Email:</strong> {{ $data['email'] ?? 'Not specified' }}</li>
        <li><strong>Phone:</strong> {{ $data['phone'] ?? 'Not specified' }}</li>
        <li><strong>Subject:</strong> {{ $data['subject'] ?? 'Not specified' }}</li>
      </ul>

      @if(!empty($data['message']))
        <p><strong>Message:</strong></p>
        <p>{{ $data['message'] }}</p>
      @endif

      <p style="margin-top: 30px;">📅 Submitted on: <strong>{{ \Carbon\Carbon::now()->format('F d, Y H:i:s') }}</strong></p>
    </div>
    <div class="email-footer">
      &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
  </div>
</body>
</html>
