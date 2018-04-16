@extends('layouts.main')

@section('content')
  @include('partials.product', ['product' => $product, 'reviewmed' => $reviewmed])
  <div class="reviews-section">
    @if(count($reviews) == 0)
      <h3>
        Be The First One to Comment!!!
      </h3>
    @endif
    @if(count($reviews) != 0)
      @each('partials.review', $reviews, 'review')
    @endif
  </div>
@endsection
