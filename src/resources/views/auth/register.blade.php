@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}">
  <div class="register-container container">
      <div class="row main">
          <div class="panel-heading">
              <div class="text-center mb-4">
                  <!-- tamanho logo 1375 x 312 -->
                  <a href="homepage.html">
                      <img class="mb-4" src="./images/logo_1.png" alt="logo" width="323.75" height="78">
                  </a>
              </div>
          </div>

          <div class="main-login main-center">
              <form class="form-horizontal" method="post" action="#">
                  <div id="form_name" class="form-group">
                      <label for="name" class="cols-sm-2 control-label">
                          Name
                      </label>

                      <div class="cols-sm-10">
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="fa fa-user fa" aria-hidden="true">
                                  </i>
                              </span>

                              <input type="text" class="form-control" name="name" id="name" required autofocus/>
                          </div>
                      </div>
                  </div>

                  <div id="form_email" class="form-group">
                      <label for="email" class="cols-sm-2 control-label">
                          Email
                      </label>

                      <div class="cols-sm-10">
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="fa fa-envelope fa" aria-hidden="true">
                                  </i>
                              </span>

                              <input type="text" class="form-control" name="email" id="email" required autofocus/>
                          </div>
                      </div>
                  </div>

                  <div id="form_username" class="form-group">
                      <label for="username" class="cols-sm-2 control-label">
                          Username
                      </label>

                      <div class="cols-sm-10">
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="fa fa-user fa" aria-hidden="true">
                                  </i>
                              </span>

                              <input type="text" class="form-control" name="username" id="username"
                                     required autofocus/>
                          </div>
                      </div>
                  </div>

                  <div id="form_password" class="form-group">
                      <label for="password" class="cols-sm-2 control-label">
                          Password
                      </label>

                      <div class="cols-sm-10">
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="fa fa-lock fa-lg" aria-hidden="true">
                                  </i>
                              </span>

                              <input type="password" class="form-control" name="password" id="password"
                                     required autofocus/>
                          </div>
                      </div>
                  </div>

                  <div id="form_confirmPassword" class="form-group">
                      <label for="confirm" class="cols-sm-2 control-label">
                          Confirm Password
                      </label>

                      <div class="cols-sm-10">
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="fa fa-lock fa-lg" aria-hidden="true">
                                  </i>
                              </span>

                              <input type="password" class="form-control" name="confirm" id="confirm"
                                     required autofocus/>
                          </div>
                      </div>
                  </div>

                  <div id="form_button" class="form-group ">
                      <button type="button" class="btn btn-success btn-lg btn-block login-button">
                          Register
                      </button>
                  </div>
              </form>
           </div>
      </div>
  </div>

  <footer id="pageFooter">
      <p>Powered by LBAW1736 - MIEIC 2017/2018</p>
  </footer>
</form>
@endsection
