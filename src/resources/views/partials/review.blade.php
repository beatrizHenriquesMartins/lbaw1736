<div class="review">
    <div class="col-sm-1">
        <div class="review-image">
            <img src="{{$review->imageurl}}"
                 alt="Costumer Image">
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
</div>
