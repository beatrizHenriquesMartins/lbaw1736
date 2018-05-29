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

        

            <li class="breadcrumb-item" aria-current="page">
                Confirmation Payment    
            </li>
        </ol>
    </nav>
    
    @if($usernames && count($usernames) != 0)
    <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>Confirm <b>Payments</b></h2>
					</div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
						
                        <th>Username</th>
                        <th>Full Name</th>
						<th>Date</th>
                        <th>Cost(€)</th>
                        <th>Confirm</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($usernames as $id => $username)
                    <tr class="user-payment row-fluid" id_purchase = {{ $id }}>
						
                        <td>{{ $username }}</td>
                        <td>{{$fullnames[$id]}}</td>
						<td>{{$dates[$id]}}</td>
                        <td>{{$costs[$id]}}</td>
                        <td>
                            <a href="#" id = "button-confirmpayment" class="confirm" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Confirm">&#xe5ca;</i></a>
                        </td>
                    </tr>                   
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

@endsection