@extends('layouts.main', ['type' => $type])

@section('content')
    @include('partials.product', ['product' => $product, 'reviewmed' => $reviewmed, 'usertype' => $type])
    <div class="reviews-section">
        @if(count($reviews) == 0)
            <h3>
                Be The First One to Comment!!!
            </h3>
        @endif

        @if(count($reviews) != 0)
            @for($i = 0; $i < count($reviews); $i++)
              @include('partials.review', ['review' => $reviews[$i], 'type' => $type])
            @endfor
        @endif
    </div>
@endsection
