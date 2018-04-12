@extends('layouts.main')

@section('content')
  @include('partials.product', ['product' => $product])
  <div class="reviews-section">
  </div>
@endsection
