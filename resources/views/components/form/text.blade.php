<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {!! Form::label($name, $label, ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {{ Form::text($name, $value, array_merge(['class' => 'form-control', 'id' => "{$name}_field"], $attributes)) }}
        {!! $errors->first($name, '<span class="help-block"><strong>:message</strong></span>') !!}
    </div>
</div>