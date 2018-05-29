<div class="review" data-id="{{$review->id_purchase}}">
    <div class="col-sm-1">
        <div class="review-image">
            <img src="{{$review->imageurl}}" alt="Customer Photo">
        </div>
    </div>

    <div class="col-sm-2">
        <div class="review-information">
            <div class="username">
                <h3>
                    {{$review->username}}
                </h3>
            </div>

            <div class="date">
                <h5>
                    {{$review->reviewdate}}
                </h5>
            </div>

            <div class="rating">

                @for($i=0; $i < $review->rating; $i++)
                    <span class="rating-addon align-content-center">
                        <i class="fa fa-star">
                        </i>
                    </span>
                @endfor

                @for($i=$review->rating; $i < 5; $i++)
                    <span class="rating-addon align-content-center grey">
                        <i class="fa fa-star">
                        </i>
                    </span>
                @endfor
            </div>
        </div>
    </div>

    <div class="col-sm-8 align-content-stretch">
        <div class="review-text align-content-stretch">
            <p>
                {{$review->textreview}}
            </p>
        </div>
    </div>

    @if(Auth::check() && $review->id_client == Auth::user()->id || $type == 4 || $type == 2)
        <div class="col-sm-1 removeComment">
            <a id="removeComment">
                <i class="fa fa-trash pull-right">
                </i>
            </a>
        </div>
    @endif
</div>
