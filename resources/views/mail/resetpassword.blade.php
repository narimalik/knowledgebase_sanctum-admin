<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Password Reset</title>
  <style>
    /* Inline-friendly, simple responsive styles */
    body { background:#f4f6f8; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial; margin:0; padding:0; -webkit-font-smoothing:antialiased; }
    .container { max-width:600px; margin:28px auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
    .header { background:#111827; color:#fff; padding:18px 24px; text-align:left; }
    .header h1 { margin:0; font-size:20px; font-weight:600; }
    .content { padding:24px; color:#0f172a; line-height:1.5; }
    .btn-wrap { text-align:center; margin:22px 0; }
    .btn { background:#2563eb; color:#fff; text-decoration:none; padding:12px 20px; border-radius:6px; display:inline-block; font-weight:600; }
    .muted { color:#6b7280; font-size:13px; }
    .footer { padding:16px 24px; font-size:13px; color:#94a3b8; background:#f8fafc; text-align:center; }

    /* small screens */
    @media (max-width:420px){
      .content { padding:16px; }
      .header, .footer { padding-left:16px; padding-right:16px; }
    }
  </style>
</head>
<body>
  <div class="container" role="article" aria-label="Password reset email">
    <div class="header">
      <h1>KnowledgeBase</h1>
    </div>

    <div class="content">
      <p style="margin-top:0;">Hi {{ $user->name ?? 'there' }},</p>

      <p>
        We received a request to reset the password for your account. Click the button below to set a new password. This link will expire in {{ $minutes ?? 60 }} minutes.
      </p>

      <div class="btn-wrap">
        <!-- actionUrl should be a fully-qualified URL -->
        <a href="{{ url($user->respasswordurl) }}" class="btn" target="_blank" rel="noopener noreferrer">Reset your password</a>
      </div>

      <p class="muted">
        If the button above does not work, copy and paste the following URL into your browser:
        <br><a href="{{ url($user->respasswordurl) }}" style="color:#2563eb; word-break:break-all;">{{ url($user->respasswordurl) }}</a>
      </p>

      <hr style="border:none;border-top:1px solid #eef2f7;margin:18px 0;">

      <p class="muted">
        If you didn’t request a password reset, you can safely ignore this email. No changes were made to your account.
      </p>

      <p style="margin-bottom:0;">Thanks,<br>The KnowledgeBase Team</p>
    </div>

    <div class="footer">
      © {{ date('Y') }} KnowledgeBase — If you need help, reply to this email or contact support.
    </div>
  </div>
</body>
</html>
