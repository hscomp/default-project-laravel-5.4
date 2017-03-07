@if($model)
    {{ Form::open(['url' => $url, 'class' => $class ?: 'form-horizontal']) }}
@else
    {{ Form::model($model, ['url' => $url, 'class' => $class ?: 'form-horizontal']) }}
@endif
    @foreach($formFields as $field)
        {{ Form::{$field['fieldType']}($field['name'], $field['label']) }}
    @endforeach
    {{ Form::submitField($submitButtonText) }}
{{ Form::close() }}