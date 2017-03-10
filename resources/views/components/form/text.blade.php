<div {!! Html::attributes(array_merge(['class' => implode(' ', array_unique(array_merge(['form-group'], $fieldRootClasses))) . ($errors->has($name) ? ' has-error' : '')], $fieldRootAttributes)) !!}>
    @if ($label != null)
        {!! Form::label($name, $label, ['class' => 'col-md-4 control-label']) !!}
    @endif
    <div class="col-md-6">
        {{ Form::text($name, $value, array_merge(['class' => 'form-control', 'id' => "{$name}_field"], $attributes)) }}
        {!! $errors->first($name, '<span class="help-block"><strong>:message</strong></span>') !!}
    </div>
</div>