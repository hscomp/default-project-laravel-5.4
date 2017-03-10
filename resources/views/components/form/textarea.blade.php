<div {!! Html::attributes(array_merge(['class' => implode(' ', array_unique(array_merge(['form-group'], $fieldRootClasses))) . ($errors->has($name) ? ' has-error' : '')], array_unique(array_merge(['id' => "{$name}_field_root"], $fieldRootAttributes)))) !!}>
    @if ($label != null)
        {!! Form::label($name, $label, ['class' => 'col-md-4 control-label']) !!}
    @endif
    <div class="col-md-6">
        {{ Form::textarea($name, $value, array_merge(['class' => 'form-control', 'id' => "{$name}_field"], $attributes)) }}
        {!! $errors->first($name, '<p class="help-block alert alert-danger">:message</p>') !!}
    </div>
</div>