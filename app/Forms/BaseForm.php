<?php

namespace App\Forms;

use App\Forms\Contracts\ModelFormInterface;

abstract class BaseForm implements ModelFormInterface
{
    private $formType;

    private $url;

    private $submitButtonText;

    private $formClass = 'form-horizontal';

    private $formAttributes = ['data-remote'];

    private $dataRemote = false;

    public function __construct($formType = 'create')
    {
        $this->setFormType($formType)
            ->setUrl($this->url($formType))
            ->setFormClass($this->formClass($formType))
            ->setFormAttributes($this->formAttributes($formType))
            ->setSubmitButtonText($this->submitButtonText($formType))
            ->setDataRemote($this->dataRemote($formType));
    }

    private function setFormType($formType)
    {
        $this->formType = $formType;

        return $this;
    }

    public function getFormType()
    {
        return $this->formType;
    }

    public function setUrl($url)
    {
        $this->url = $this->parseValueByFormType($url);

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setFormClass($formClass)
    {
        $this->formClass = $this->parseValueByFormType($formClass);

        return $this;
    }

    public function getFormClass()
    {
        return $this->formClass;
    }

    public function setFormAttributes($attributes)
    {
        $this->formAttributes = $this->parseValueByFormType($attributes);

        return $this;
    }

    public function getFormAttributes()
    {
        return $this->formAttributes;
    }

    public function setSubmitButtonText($submitButtonText)
    {
        $this->submitButtonText = $this->parseValueByFormType($submitButtonText);

        return $this;
    }

    public function getSubmitButtonText()
    {
        return $this->submitButtonText;
    }

    public function setDataRemote($dataRemote)
    {
        $this->dataRemote = $this->parseValueByFormType($dataRemote);;

        return $this;
    }

    public function getDataRemote($dataRemote)
    {
        $this->dataRemote = $dataRemote;

        return $this;
    }

    public function getRules()
    {
        $rules = [];

        foreach ($this->fields() as $rule => $data) {
            if (isset($data[$this->formType]) && $data[$this->formType]) {
                $rules[$rule] = isset($data['rules']) ? $data['rules'] : [];
            }
        }

        return $rules;
    }

    public function getFields()
    {
        $fields = [];

        foreach ($this->fields() as $rule => $data) {
            if (in_array($this->formType, explode('|', $data['formType']))) {
                $fields[$rule] = [
                    'fieldComponent' => $this->parseValueByFormType($data['fieldComponent']),
                    'fieldType' => $this->parseValueByFormType($data['fieldType']),
                    'name' => $rule,
                    'label' => $this->parseValueByFormType($data['label']),
                    'attributes' => isset($data['attributes']) ? $this->parseValueByFormType($data['attributes']) : [],
                    'parentClass' => isset($data['parentClass']) ? $this->parseValueByFormType($data['parentClass']) : '',
                    'parentAttributes' => isset($data['parentAttributes']) ? $this->parseValueByFormType($data['parentAttributes']) : [],
                ];
            }
        }

        return $fields;
    }

    public function render($model = null)
    {
        return view('components.form.renderForm', [
            'form' => $this,
            'model' => $model,
        ])->render();
    }

    public function hasRenderFields($formType = null)
    {
        return count($this->getFields($formType)) > 0;
    }

    public function fields()
    {
        return [];
    }

    public function url()
    {
        return [];
    }

    public function formClass()
    {
        return '';
    }

    public function formAttributes()
    {
        return [];
    }

    public function submitButtonText($formType)
    {
        return '';
    }

    public function dataRemote($formType)
    {
        return false;
    }

    private function parseValueByFormType($data)
    {
        if (is_array($data) && count($data)) {
            foreach ($data as $types => $value) {
                if (in_array($this->formType, explode('|', $types))) {
                    return $value;
                }
            }
        } else {
            return $data;
        }

        return $data;
    }

}
