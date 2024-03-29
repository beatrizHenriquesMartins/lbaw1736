<div class="product">
    <div class="product-image">
        <a href="/products/{{$product->id}}">
            <img src="{{$product->imageurl}}" alt="Product Image">
        </a>
    </div>

    <div class="product-name">
        <h3>
            <a href="/products/{{ $product->id }}">
                {{ $product->name }}
            </a>
        </h3>
        <?php $brandname = str_replace(' ', '_', $product->brandname);?>
        <a href="/brands/{{ $brandname }}">
            <h4>
                {{$product->brandname}}
            </h4>
        </a>

        <a href="/brands/{{ $product->categoryname }}">
            <h5>
                {{$product->categoryname}}
            </h5>
        </a>

        <h5>
            {{ $product->price }} €
        </h5>
    </div>

    <div class="product-class">
        <div class="btns">
            <div class="cart-btn">
                <button  class="btn btn-info pull-right purchase-btn" data-toggle="modal"
                        data-target="#exampleModal{{$product->id}}">
                    Review
                </button>

                <div class="modal fade" id="exampleModal{{$product->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel{{$product->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form class="review-body" method="post" action="{{ route('addreview', ['id_product' => $product->id, 'id_purchase' => $product->id_purchase]) }}">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">
                                            Review:
                                        </label>

                                        <textarea class="form-control" id="message-text" name="reviewtext"></textarea>
                                    </div>

                                    <!-- Rating -->
                                    <input class="rating ratable" data-max="5" data-min="1" id="some_id" name="rating"
                                           type="number" />
                                </div>

                                <div class="modal-footer">
                                    <button  class="btn btn-secondary" data-dismiss="modal">
                                        Close
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        Send message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
