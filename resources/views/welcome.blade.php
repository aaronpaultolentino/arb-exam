@extends('layout.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-5">
        	<center>
        		<img src="{{ url('assets/arb.jpg') }}" style="width: 30%;" class="mb-2">
        		<h1 style="font-weight: bold;">Expense Manager</h1>
        	</center>
        </div>
        <div class="col-md-12">
            <datatable-component></datatable-component>
        </div>
    </div>
</div>
@endsection