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
    @if($names && count($names) != 0)
        @foreach($names as $id => $username)
            <div class="user-payment row-fluid" id_purchase = {{ $id }} >
                <div class = "col-sm-5">
                    {{$username}}
                </div>
                <div class = "col-sm-3">
                    {{$costs[$id]}}
                </div>
                <div class = "col-sm-2">
                <button id = "button-confirmpayment" type="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-ok"></span> Ok 
        </button>
                </div>                
            </div>
        @endforeach
    @endif
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
                    <tr>
						
                        <td>Thomas Hardy</td>
                        <td>thomashardy@mail.com</td>
						<td>89 Chiaroscuro Rd, Portland, USA</td>
                        <td>(171) 555-2222</td>
                        <td>
                            <a href="#" id = "button-confirmpayment" class="confirm" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Confirm">&#xe5ca;</i></a>
                        </td>
                    </tr>
                    <tr>
						
                        <td>Thomas Hardy</td>
                        <td>thomashardy@mail.com</td>
						<td>89 Chiaroscuro Rd, Portland, USA</td>
                        <td>(171) 555-2222</td>
                        <td>
                            <a href="#" id = "button-confirmpayment" class="confirm" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Confirm">&#xe5ca;</i></a>
                        </td>
                    </tr>
					<tr>
						
                        <td>Thomas Hardy</td>
                        <td>thomashardy@mail.com</td>
						<td>89 Chiaroscuro Rd, Portland, USA</td>
                        <td>(171) 555-2222</td>
                        <td>
                            <a href="#" id = "button-confirmpayment" class="confirm" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Confirm">&#xe5ca;</i></a>
                        </td>
                    </tr>
                    <tr>
						
                        <td>Thomas Hardy</td>
                        <td>thomashardy@mail.com</td>
						<td>89 Chiaroscuro Rd, Portland, USA</td>
                        <td>(171) 555-2222</td>
                        <td>
                            <a href="#" id = "button-confirmpayment" class="confirm" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Confirm">&#xe5ca;</i></a>
                        </td>
                    </tr>				
					<tr>
						
                        <td>Thomas Hardy</td>
                        <td>thomashardy@mail.com</td>
						<td>89 Chiaroscuro Rd, Portland, USA</td>
                        <td>(171) 555-2222</td>
                        <td>
                            <a href="#" id = "button-confirmpayment" class="confirm" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Confirm">&#xe5ca;</i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection