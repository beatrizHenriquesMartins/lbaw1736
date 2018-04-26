@extends('layouts.main', ['type' => $type])

@section('content')
<!-- breadcrumbs -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="homepage.html">
                Homepage
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="admin_users.html">
                Profile
            </a>
        </li>

        <li class="breadcrumb-item" aria-current="page">
          @if($page == 1)
            List Clients
          @endif
          @if($page == 2)
            List Brand Managers
          @endif
          @if($page == 3)
            List SupportChats
          @endif
          @if($page == 4)
            List Banned Users
          @endif
        </li>
    </ol>
</nav>


<div class="container-fluid main">
    <div class="row-fluid category-section wishlist-section">
        <div class = "sidelinks col-sm-2">
            <div class="list-group">
                <a href="customer_profile.html" class="list-group-item list-group-item-action">
                    Profile
                </a>

                <a href="/clients" @if($page == 1) class="list-group-item list-group-item-action active" @endif @if($page != 1) class="list-group-item list-group-item-action" @endif>
                    List of Clients
                </a>

                <a href="/bms" @if($page == 2) class="list-group-item list-group-item-action active" @endif @if($page != 2) class="list-group-item list-group-item-action" @endif>
                    List of Brand Managers
                </a>

                <a href="/supports" @if($page == 3) class="list-group-item list-group-item-action active" @endif @if($page != 3) class="list-group-item list-group-item-action" @endif>
                    List of SupportChat
                </a>
                <a href="/bans" @if($page == 4) class="list-group-item list-group-item-action active" @endif @if($page != 4) class="list-group-item list-group-item-action" @endif>
                    List of Banned Users
                </a>
            </div>
        </div>

        <div class = "category-products wishlist-products col-sm-8 col-sm-offset-1">
            <div id="accordion">
              @for($i = 0; $i < count($users); $i++)
                @include('partials.adminusers', ['user' => $users[$i], 'page' => $page])
              @endfor


            </div>
        </div>
    </div>
</div>
<div class="category-links">
  {{ $users->links() }}
</div>
@endsection
