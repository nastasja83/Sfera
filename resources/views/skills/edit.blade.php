{!!Form::model($skill, ['url' => route('skills.update', ['skill' => $skill]), 'method' => 'PATCH', 'id' => $skill->id]) !!}
<div class="input-group">
{{Form::text('skill_name', $skill->skill_name, ['class' => 'form-control-plaintext', 'id' => $skill->skill_name])}}
  <div class="input-group-append">
    <label for={{ $skill->skill_name }}>
        {{ Form::button('<i class="bi bi-pencil-square"></i>', ['class' => 'btn btn-link disabled', 'type' => 'submit']) }}
    </label>
  </div>
</div>
{!!Form::close()!!}
