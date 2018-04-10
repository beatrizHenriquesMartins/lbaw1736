<?php

namespace App\Policies;

use App\Client;
use App\Product;
use App\Wishlist;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class WishlistPolicy
{
    use HandlesAuthorization;

    public function list(Client $client)
    {
      // Any user can list its own cards
      return Auth::check();
    }

    public function create(Client $client)
    {
      // Any user can add a new product to their wishlist
      return Auth::check();
    }

    public function delete(Client $client, Wishlist $wishlist, Product $product)
    {
      // Only a owner can delete it
      return ($client->id_client == $wishlist->$id_client && $product->id == $wishlist->id_product);
    }
}
