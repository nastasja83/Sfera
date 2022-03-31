@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-6">
            <h1 class="mt-3 mb-3">{{ __('users.Change data') }}</h1>
            {{Form::model($user, ['url' => route('users.update', ['user' => $user]), 'method' => 'PATCH'])}}
                <div class="form-group mb-3">
                    {{Form::label('last_name', __('users.Last name'))}}
                    {{Form::text('last_name', $user->last_name, ['class' => 'form-control'])}}
                    @if ($errors->has('last_name'))
                        @error('last_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
                <div class="form-group mb-3">
                    {{Form::label('first_name', __('users.First name'))}}
                    {{Form::text('first_name', $user->first_name, ['class' => 'form-control'])}}
                    @if ($errors->has('first_name'))
                        @error('first_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
                <div class="form-group mb-3">
                    {{Form::label('middle_name', __('users.Middle name'))}}
                    {{Form::text('middle_name', $user->middle_name, ['class' => 'form-control'])}}
                    @if ($errors->has('middle_name'))
                        @error('middle_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
                <div class="form-group mb-3">
                    {{Form::label('phone', __('users.Phone'))}}
                    {{Form::text('phone', $user->phone, ['class' => 'form-control'])}}
                    @if ($errors->has('phone'))
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
                <div class="form-group mb-3">
                    {{Form::label('email', __('users.E-Mail Address'))}}
                    {{Form::email('email', $user->email, ['class' => 'form-control'])}}
                    @if ($errors->has('email'))
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
                @if(Auth::user()->isAdmin())
                    <div class="form-group mb-3">
                        {{Form::label('position_id', __('positions.Position'))}}
                        {{Form::select('position_id', $positions, $user->position_id, ['class' => 'form-control'])}}
                        @if ($errors->has('position_id'))
                            @error('position_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        {{Form::label('skill_id', __('skills.Skills'))}}
                        {{Form::select('skill_id', $skills, $user->skills, ['placeholder' => '', 'multiple' => 'multiple', 'size' => '7', 'name' => 'skills[]', 'class' => 'form-control'])}}
                        @if ($errors->has('skill_id'))
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-check form-check-inline">
                        {{Form::radio('is_admin', 1, ['name' => 'admin', 'class' => 'form-check-input'])}}
                        {{Form::label('is_admin', __('users.isAdmin'), ['class' => 'form-check-label ml-2'])}}
                    </div>
                    <div class="form-check form-check-inline">
                        {{Form::radio('is_admin', 0, ['name' => 'admin', 'class' => 'form-check-input'])}}
                        {{Form::label('is_admin', __('users.isNotAdmin'), ['class' => 'form-check-label ml-2'])}}
                    </div>
                @endif
                <div>
                    {{Form::submit(__('buttons.Update'), ['class' => 'btn btn-primary mt-3'])}}
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection
