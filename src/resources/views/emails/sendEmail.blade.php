Hello <i>{{ $user->firstname }} {{ $user->lastname}}</i>,
<p>You are receiving this email because we received a password reset request for your account. Click the button below to reset your password:</p>

<div>
  <a role="button" href="http://127.0.0.1:8000/auth/reset/{{$token}}"> Reset Password</a>

</div>

Thank You,
<br/> Amazonas
