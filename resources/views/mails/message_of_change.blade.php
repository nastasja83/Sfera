@component('mail::message')
# {{ __('mail.Change in the employee card') }}

{{ __('mail.Hello')}}, {{ $user->first_name }}!

{{ __('mail.Changes have been made to the employee card:') }}

<ul>
    @if ($userChange->has('position_id'))
        <li>{{ __('mail.Position') }} {{ $user->position->position_name }}</li>
    @endif
    @if ($skillsChange->isNotEmpty())
        <li>{{ __('mail.Skills') }}
            @foreach ($user->skills as $skill)
            <div>{{ $skill->skill_name }}</div>
            @endforeach
        </li>
    @endif
    @if ($userChange->has('is_admin'))
        @if ($user->is_admin === "1")
            <li>{{ __('mail.You have been appointed administrator') }}</li>
        @elseif ($user->is_admin === "0")
            <li>{{ __('mail.Administrator rights removed') }}</li>
        @endif
    @endif

</ul>

@component('mail::button', ['url' => route('users.edit', ['user' => $user])])
{{ __('mail.View changes') }}
@endcomponent

{{ __('mail.Best regards') }}<br>
{{ config('app.name') }}
@endcomponent
