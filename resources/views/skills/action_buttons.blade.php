
{{ Form::button('Update', ['class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'form' => $skill->id]) }}
<a href="{{ route('skills.destroy', ['skill' => $skill->id]) }}" class="btn btn-outline-danger btn-sm" data-method="delete" rel="nofollow" data-confirm="{{ __('tasks.Are you sure?') }}" aria-pressed="true">Delete</a>

