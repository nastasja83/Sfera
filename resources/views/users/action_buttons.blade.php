@if (Auth::check())
    @if (Auth::user()->isAdmin())
        <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">{{ __('buttons.Edit') }}</a>
        <a href="{{ route('users.destroy', ['user' => $user]) }}" class="btn btn-outline-danger btn-sm" data-method="delete" rel="nofollow" data-confirm="{{ __('buttons.Are you sure?') }}" aria-pressed="true">{{ __('buttons.Delete') }}</a>
    @elseif (Auth::user()->id === $user->id)
        <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">{{ __('buttons.Edit') }}</a>
    @endif
@endif
