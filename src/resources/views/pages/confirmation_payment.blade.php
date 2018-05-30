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
    
    
    <div class="row-fluid">
    <div class = "col-sm-1">
    </div>
    <div class="table-wrapper col-sm-10">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>Unconfirmed <b>Purchases:</b></h2>
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
                        <th>Confirm Payment</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($usernames as $id => $username)
                    <tr class="user-payment row-fluid" id_purchase = {{ $id }}>
						
                        <td>{{ $username }}</td>
                        <td>{{$fullnames[$id]}}</td>
						<td>{{$dates[$id]}}</td>
                        <td>&nbsp;{{$costs[$id]}}</td>
                        <td>
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="#" id = "button-confirmpayment" class="confirm" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Confirm">&#xe5ca;</i></a>
                        </td>
                    </tr>                   
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class = "col-sm-1">
    </div>
    </div>
   

@endsection