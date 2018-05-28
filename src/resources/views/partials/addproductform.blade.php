{{csrf_field()}}
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

                <input type="text" class="form-control" name="name" id="name" @if(old('name'))value="{{old('name')}}"@endif autofocus required>

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
                    @for($i = 0; $i < count($brands); $i++)
                        <option value="{{$brands[$i]->id_brand}}">{{$brands[$i]->brandname}}</option>
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
                    @for($i = 0; $i < count($categories); $i++)
                        <option value="{{$categories[$i]->id_category}}">{{$categories[$i]->categoryname}}</option>
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

                <input type="text" class="form-control" name="price" id="price" @if(old('price'))value="{{old('price')}}"@endif autofocus required>

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
                          autofocus>@if(old('bigdescription')){{old('bigdescription')}}@endif</textarea>

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
                          autofocus>@if(old('shortdescription')){{old('shortdescription')}}@endif</textarea>

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

                <input type="checkbox" name="tocarousel" id="tocarousel">
                </input>
            </div>

            <div class="quantityinstock">
                <h2>
                    Quantity in Stock
                </h2>

                <input type="number" name="quantityinstock" id="quantityinstock">
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
