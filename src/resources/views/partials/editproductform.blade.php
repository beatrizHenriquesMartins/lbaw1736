{{csrf_field()}}
<div class="product-section">
    <div class="col-sm-4">
        <div class="product-image">
            <img src="{{ asset($product->imageurl) }}" alt="Product Image">

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

                <input type="text" class="form-control" name="name" id="name" value="{{$product->name}}" autofocus>

                @if ($errors->has('name'))
                    <span class="error">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>

            <div class="Brand">
                <h2>
                    Brand
                </h2>

                <select name="brandname">
                    <option value="{{$product->brand->id_brand}}">{{$product->brand->brandname}}</option>

                    @for($i = 0; $i < count($brands); $i++)
                        @if($product->brand->id_brand != $brands[$i]->id_brand)
                            <option value="{{$brands[$i]->id_brand}}">{{$brands[$i]->brandname}}</option>
                        @endif
                    @endfor
                </select>

                @if ($errors->has('brandname'))
                    <span class="error">
                        {{ $errors->first('brandname') }}
                    </span>
                @endif
            </div>

            <div class="Brand">
                <h2>
                    Category
                </h2>

                <select name="categoryname">
                    <option value="{{$product->category->id_category}}">{{$product->category->categoryname}}</option>

                    @for($i = 0; $i < count($categories); $i++)
                        @if($product->category->id_category != $categories[$i]->id_category)
                            <option value="{{$categories[$i]->id_category}}">{{$categories[$i]->categoryname}}</option>
                        @endif
                    @endfor
                </select>

                @if ($errors->has('categoryname'))
                    <span class="error">
                        {{ $errors->first('categoryname') }}
                    </span>
                @endif
            </div>

            <div class="Price">
                <h2>
                    Price
                </h2>

                <input type="text" class="form-control" name="price" id="price" value="{{$product->price}}" autofocus>

                @if ($errors->has('price'))
                    <span class="error">
                        {{ $errors->first('price') }}
                    </span>
                @endif
            </div>

            <div class="Bigdescription">
                <h2>
                    Big Description
                </h2>

                <textarea rows="7" cols="70" class="form-control" name="bigdescription" id="bigdescription"
                          autofocus>{{$product->bigdescription}}</textarea>

                @if ($errors->has('bigdescription'))
                    <span class="error">
                        {{ $errors->first('bigdescription') }}
                    </span>
                @endif
            </div>

            <div class="Shortdescription">
                <h2>
                    Short Description
                </h2>

                <textarea rows="3" cols="70" class="form-control" name="shortdescription" id="shortdescription"
                          autofocus>{{$product->shortdescription}}</textarea>

                @if ($errors->has('shortdescription'))
                    <span class="error">
                        {{ $errors->first('shortdescription') }}
                    </span>
                @endif
            </div>

            <div class="tocarousel">
                <h2>
                    Product in Carousel
                </h2>

                <input type="checkbox" name="tocarousel" id="tocarousel" @if($product->tocarousel == 1) checked @endif>
                </input>
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
