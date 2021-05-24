@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Expense Categories') }}</div>

                <div class="card-body">

                    <expense-categories-datatable-component></expense-categories-datatable-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
