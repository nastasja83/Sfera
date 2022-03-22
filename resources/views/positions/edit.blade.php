{!!Form::model($position, ['url' => route('positions.update', ['position' => $position]), 'method' => 'PATCH', 'id' => 'position_update']) !!}
<div class="input-group">
{{Form::text('position_name', $position->position_name, ['class' => 'form-control-plaintext', 'id' => 'input_position'])}}
  <div class="input-group-append">
    <label for="input_position">
        {{ Form::button('<i class="bi bi-pencil-square"></i>', ['class' => 'btn btn-link disabled', 'type' => 'submit']) }}
    </label>
  </div>
</div>
{!!Form::close()!!}
