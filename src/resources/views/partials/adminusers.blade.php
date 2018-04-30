<div class="card" data-id="{{$user->id}}">
    <div class="card-header" id="heading{{$user->id}}">
        <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$user->id}}" aria-expanded="false" aria-controls="collapse{{$user->id}}">
              {{$user->username}}
            </button>
        </h5>
    </div>

    <div id="collapse{{$user->id}}" class="collapse" aria-labelledby="heading{{$user->id}}" data-parent="#accordion">
        <div class="card-body">
            <div class="product">
                <div class="product-image">
                    <a href="/users/{{$user->id}}">
                        <img src="{{$user->imageurl}}" alt="User Image">
                    </a>
                </div>

                <div class="product-name">
                    <a href="">
                        <h3>
                            {{$user->username}}
                        </h3>
                    </a>
                    <h5>
                        {{$user->firstname}} {{$user->lastname}}
                    </h5>
                </div>

                <div class="product-class">
                    <div class="btns">
                        <div class="cart-btn">
                            <button type="button" @if($page != 4) class="btn btn-danger pull-right fa fa-ban" @endif @if($page == 4) class="btn btn-info pull-right fa fa-undo" @endif>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
