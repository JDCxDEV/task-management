@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 pb-2">
                    <project-create-or-delete create-url="{{ route('project.store') }}" />
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
                    
                    <dashboard task-create-url="{{ route('task.store') }}"></dashboard>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
