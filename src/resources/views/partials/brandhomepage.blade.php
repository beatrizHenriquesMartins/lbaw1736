<?php         $brandname = str_replace(' ', '_', $brand->brandname);
if($elem == 1 || $elem == 2 || $elem == 4 || $elem == 5 || $elem == 7 || $elem == 8) {?>

<div class="brand-banner-box notstrech">
    <a href="/brands/{{$brandname}}">
        <img src="{{$brand->brandimgurl}}" alt="Brand {{$brand->brandname}}" class="img-responsive img-center">
    </a>
</div>

<?php } else {?>
<div class="brand-banner-box stretch">
    <a href="/brands/{{$brandname}}">
        <img src="{{$brand->brandimgurl}}" alt="Brand {{$brand->brandname}}" class="img-responsive img-center">
    </a>
</div>
<?php } ?>
