{!!Form::model($skill, ['url' => route('skills.update', ['skill' => $skill]), 'method' => 'PATCH', 'id' => 'skill_update']) !!}
<div class="input-group">
{{Form::text('skill_name', $skill->skill_name, ['class' => 'form-control-plaintext', 'id' => 'input_skill'])}}
  <div class="input-group-append">
    <label for="input_skill">{{ Form::button('<i class="bi bi-pencil-square"></i>', ['class' => 'btn btn-link disabled', 'type' => 'submit']) }}</label>
  </div>
</div>
{!!Form::close()!!}
