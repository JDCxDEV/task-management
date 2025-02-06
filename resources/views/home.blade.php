@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 pb-2">
                    <button class="btn btn-success">Add New Project</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Task Management') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <dashboard></dashboard>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
