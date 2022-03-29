@component('mail::message')
# Изменениe в карточке сотрудника

Добрый день, {{ $user->first_name}}!

В карточку сотрудника были внесены изменения:

<ul>
    @if ($userChange->has('position_id'))
        <li>Position: {{ $user->position->position_name }}</li>
    @endif
    @if ($skillsChange->isNotEmpty())
        <li>Skills:
            @foreach ($user->skills as $skill)
            <div>{{ $skill->skill_name }}</div>
            @endforeach
        </li>
    @endif
    @if ($userChange->has('is_admin'))
        @if ($user->is_admin === "1")
            <li>Вы назначены администратором</li>
        @elseif ($user->is_admin === "0")
            <li>Права администратора удалены</li>
        @endif
    @endif

</ul>

@component('mail::button', ['url' => route('users.edit', ['user' => $user])])
Посмотреть изменения
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent
