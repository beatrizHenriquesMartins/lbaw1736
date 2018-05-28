@extends('layouts.main', ['type' => $type])

@section('title', $title)

@section('content')
<div class="container contactus">
  <h3><strong>Contact Us</strong></h3>

<div class="row form">
  <div class="col-sm-7">
    <div class="mapouter">
      <div class="gmap_canvas">
        <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Faculdade Engenharia do Porto&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        <a href="https://www.pureblack.de/webdesign-kiel/">pure black</a>
      </div>
      <style>.mapouter{text-align:right;height:500px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style>
    </div>
  </div>

    <div class="col-sm-5">
        <h4><strong>Get in Touch</strong></h4>
      <form role="form" action="{{ route('contactusmail') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
          <input type="text" class="form-control" name="name" value="" placeholder="Name">
        </div>
        <div class="form-group">
          <input type="email" class="form-control" name="email" value="" placeholder="E-mail">
        </div>
        <div class="form-group">
          <input type="tel" class="form-control" name="phone" value="" placeholder="Phone">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="subject" value="" placeholder="Subject">
        </div>
        <div class="form-group">
          <textarea class="form-control" name="message" rows="3" placeholder="Message"></textarea>
        </div>
        <button class="btn btn-default" type="submit" name="button">
            <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Submit
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
