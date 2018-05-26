@extends('layouts.main', ['type' => $type])

@section('title', $title)

@section('content')
    <!-- breadcrumbs -->
    <nav id="breadcrumbs" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/homepage">
                    Homepage
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{route('category', ['categoryname' => $product->category->categoryname])}}">
                    {{$product->category->categoryname}}
                </a>
            </li>

            <li class="breadcrumb-item">
              <?php $brandname = str_replace(' ', '_', $product->brand->brandname); ?>
                <a href="{{route('brand', ['brandname' => $brandname])}}">
                    {{$product->brand->brandname}}
                </a>
            </li>

            <li class="breadcrumb-item" aria-current="page">
              <a href="{{route('product', ['id' => $product->id])}}">
                  {{$product->name}}
              </a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <form method="POST" action="{{ route('editproduct', ['id' => $product->id]) }}" enctype="multipart/form-data">
        @include('partials.editproductform', ['product' => $product, 'brands' => $brands])
    </form>
@endsection
