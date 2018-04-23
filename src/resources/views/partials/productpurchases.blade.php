<div class="product">
    <div class="product-image">
        <img src="{{$product->imageurl}}" alt="Product Image">
    </div>

    <div class="product-name">
      <h3>
          <a href="/products/{{ $product->id }}">
              {{ $product->name }}
          </a>
      </h3>

      <a href="/brands/{{ $product->brandname }}">
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
                <button type="button" class="btn btn-info pull-right purchase-btn" data-toggle="modal"
                        data-target="#exampleModal">
                    Review
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" data-id="{{$product->id}}">
                            <div class="modal-body" data-id="{{$product->id_purchase}}">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">
                                            Review:
                                        </label>

                                        <textarea class="form-control" id="message-text">
                                        </textarea>
                                    </div>

                                    <!-- Rating -->
                                    <div id="colorstar" class="starrr ratable" >
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Close
                                </button>

                                <button type="button" class="btn btn-primary">
                                    Send message
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
