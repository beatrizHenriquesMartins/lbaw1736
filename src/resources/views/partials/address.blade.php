<li class="row address" data-id="{{$address->id_address}}">
    <div class="col-xs-9">
        {{ $address->address . " " . $address->city . " " . $address->country}}
    </div>

    <div class="col-xs-3">
        <button  class="btn btn-default btn-sm">
            <span class="fa fa-remove">
            </span>
        </button>
    </div>
</li>
