<?php

namespace App\Policies;

use App\Client;
use App\Product;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CartPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {

      // Any user can list its own cards
      return Auth::check();
    }

    public function create(Client $client)
    {
      // Any user can add a new product to their wishlist
      return Auth::check();
    }

    public function delete(User $user, Product $product)
    {

      // Only a owner can delete it
      $client = Client::find($user->id);
      $product = $client->wishlist()->find((int)$product->id);

      return $product != null;
    }
}
