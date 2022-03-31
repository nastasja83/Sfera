@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1 class="mb-3 mt-3">{{ __('positions.Create position') }}</h1>
            {{Form::open(['url' => route('positions.store'), 'class' => 'w-50'])}}
                <div class="form-group mb-3">
                    {{Form::label('position_name', __('positions.Position name'))}}
                    {{Form::text('position_name', '', ['class' => 'form-control'])}}
                    <div class="invalid-feedback d-block">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    @endif
                    </div>
                </div>
                    {{Form::submit(__('buttons.Create'), ['class' => 'btn btn-primary mt-3'])}}
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection('content')
