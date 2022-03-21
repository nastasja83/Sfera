{!!Form::model($skill, ['url' => route('skills.update', ['skill' => $skill]), 'method' => 'PATCH']) !!}
<div class="input-group">
{{Form::text('skill_name', $skill->skill_name, ['class' => 'form-control-plaintext', 'aria-describedby' => 'basic-addon2'])}}
  <div class="input-group-append">
  {{ Form::button('<i class="bi bi-pencil-square"></i>', ['class' => 'btn btn-link disabled', 'type' => 'button']) }}
  </div>
</div>
{!!Form::close()!!}
