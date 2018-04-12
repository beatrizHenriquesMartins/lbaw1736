<div class="review">
    <div class="col-sm-1">
        <div class="review-image">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/Shahter-Reak_M_2015_cropped_%2818%29.jpg"
                 alt="Costumer Image">
        </div>
    </div>

    <div class="col-sm-2">
        <div class="review-information">
            <div class="username">
                <h3>
                    cr7
                </h3>
            </div>

            <div class="date">
                <h5>
                    {{$review->reviewDate}}
                </h5>
            </div>


        </div>
    </div>

    <div class="col-sm-8 align-content-stretch">
        <div class="review-text align-content-stretch">
            <p>
              {{$review->textReview}}
            </p>
        </div>
    </div>
</div>
