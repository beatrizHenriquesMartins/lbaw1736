Hello <i>{{ $user->firstname }} {{ $user->lastname}}</i>,
<p>You are receiving this email because we received a password reset request for your account. Click the button below to reset your password:</p>

<div>
  <a role="button" href="http://lbaw1736.lbaw-prod.fe.up.pt/auth/reset/{{$token}}"> Reset Password</a>

</div>

Thank You,
<br/> Amazonas
