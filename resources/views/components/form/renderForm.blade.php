<?php
/**
 * @var \App\Forms\BaseForm $form
 */
?>

@if($model)
    {{ Form::model($model, array_merge(['url' => $form->getUrl(), 'class' => implode(' ', array_unique($form->getFormClasses()))], $form->getFormAttributes())) }}
@else
    {{ Form::open(array_merge(['url' => $form->getUrl(), 'class' => implode(' ', array_unique($form->getFormClasses()))], $form->getFormAttributes())) }}
@endif

    @foreach($form->getFields() as $field)
        @if(in_array($field['fieldType'], ['text', 'textarea']))
            {{ Form::{$field['fieldComponent']}($field['name'], $field['label'], null, $field['attributes'], $field['fieldRootClasses'], $field['fieldRootAttributes']) }}
        @elseif(in_array($field['fieldType'], ['password']))
            {{ Form::{$field['fieldComponent']}($field['name'], $field['label'], $field['attributes'], $field['fieldRootClasses'], $field['fieldRootAttributes']) }}
        @endif
    @endforeach

    {{ Form::submitField($form->getSubmitButtonText()) }}

{{ Form::close() }}