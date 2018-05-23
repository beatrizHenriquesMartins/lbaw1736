@extends('layouts.main', ['type' => $type])

@section('title', $title)

@section('content')

     <!-- breadcrumbs -->
        <nav id="breadcrumbs" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('homepage')}}">
                        Homepage
                    </a>
                </li>

                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{route('homepage')}}">
                        Profile
                    </a>
                </li>

                <li class="breadcrumb-item">
                    Brands
                </li>

            </ol>
        </nav>

        <div class="container-fluid main">
          <div class="row-fluid category-section wishlist-section">
                <div class = "sidelinks col-sm-2">
                    <div class="list-group">

                            <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                                Profile
                            </a>

                            <a href="{{ route('brands') }}" class="list-group-item list-group-item-action active">
                                Brands
                            </a>
                    </div>
                </div>
                <div class = "category-products wishlist-products col-sm-8 col-sm-offset-1">
                  <div class = "row">
                      <form class = "form-horizontal" role="form" action="{{route('addbrand')}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}

                          <div class="product-section">
                              <div class="col-sm-4">
                                  <div class="product-image">
                                      <input id="imageUpload" type="file" name="imageurl" placeholder="Photo" capture>
                                      @if ($errors->has('imageurl'))
                                          <span class="error">
                                              {{ $errors->first('imageurl') }}
                                          </span>
                                      @endif
                                  </div>
                              </div>

                              <div class="col-sm-5">
                                  <div class="product-name">
                                      <div class="name">
                                          <h2>
                                              Name
                                          </h2>

                                          <input type="text" class="form-control" name="brandname" id="brandname" @if(old('brandname'))value="{{old('brandname')}}"@endif autofocus required>

                                          @if ($errors->has('brandname'))
                                              <span class="error">
                                                  {{ $errors->first('brandname') }}
                                              </span>
                                          @endif
                                      </div>

                                      <div class="Price">
                                          <h2>
                                              Contact
                                          </h2>

                                          <input type="text" class="form-control" name="cellphone" id="cellphone" @if(old('cellphone'))value="{{old('cellphone')}}"@endif autofocus required>

                                          @if ($errors->has('cellphone'))
                                              <span class="error">
                                                  {{ $errors->first('cellphone') }}
                                              </span>
                                          @endif
                                      </div>

                                  </div>
                              </div>

                              <div class="col-sm-2">
                                  <div id="form_button" class="form-group ">
                                      <button type="submit" class="btn btn-success btn-lg btn-block login-button">
                                          Submit
                                      </button>
                                  </div>
                              </div>
                          </div>

                      </form>
                  </div>
                </div>
            </div>
        </div>
@endsection
