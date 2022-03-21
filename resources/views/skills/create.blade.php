@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1 class="mb-3 mt-3">{{ __('skills.Create skill') }}</h1>
            {{Form::open(['url' => route('skills.store'), 'class' => 'w-50'])}}
                <div class="form-group mb-3">
                    {{Form::label('skill_name', __('skills.Skill name'))}}
                    {{Form::text('skill_name', '', ['class' => 'form-control'])}}
                    <div class="invalid-feedback d-block">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    @endif
                    </div>
                </div>
                    {{Form::submit(__('skills.Create'), ['class' => 'btn btn-primary mt-3'])}}
            {{ Form::close() }}
        </div>
    </div>
</div>
            @endsection('content')
