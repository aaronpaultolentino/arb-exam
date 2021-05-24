@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Roles') }}</div>

                <div class="card-body">

                    <roles-datatable-component></roles-datatable-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
