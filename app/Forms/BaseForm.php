<?php

namespace App\Forms;

use App\Forms\Contracts\ModelFormInterface;

abstract class BaseForm implements ModelFormInterface
{
    private $formType;

    private $url;

    private $formClasses = [];

    private $formAttributes = [];

    private $commonFieldRootClasses = [];

    private $commonFieldRootAttributes = [];

    private $submitButtonText;

    private $dataRemote = false;

    public function __construct($formType = 'create')
    {
        $this->setFormType($formType)
            ->setUrl($this->url())
            ->setFormClasses($this->formClasses())
            ->setFormAttributes($this->formAttributes())
            ->setCommonFieldRootClasses($this->commonFieldRootClasses())
            ->setCommonFieldRootAttributes($this->commonFieldRootAttributes())
            ->setSubmitButtonText($this->submitButtonText())
            ->setDataRemote($this->dataRemote());
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

    public function setFormClasses($formClasses)
    {
        $this->formClasses = $this->parseValueByFormType($formClasses);

        return $this;
    }

    public function getFormClasses()
    {
        return $this->formClasses;
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

    public function setCommonFieldRootClasses($commonFieldRootClasses)
    {
        $this->commonFieldRootClasses = $this->parseValueByFormType($commonFieldRootClasses);

        return $this;
    }

    public function getCommonFieldRootClasses()
    {
        return $this->commonFieldRootClasses;
    }

    public function setCommonFieldRootAttributes($commonFieldRootAttributes)
    {
        $this->commonFieldRootAttributes = $this->parseValueByFormType($commonFieldRootAttributes);

        return $this;
    }

    public function getCommonFieldRootAttributes()
    {
        return $this->commonFieldRootAttributes;
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
        $this->dataRemote = $this->parseValueByFormType($dataRemote);

        if ($dataRemote) {
            $this->formAttributes['data-remote'] = 'data-remote';
        }

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
            if (in_array($this->formType, explode('|', $data['formType']))) {
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
                    'label' => isset($data['label']) ? $this->parseValueByFormType($data['label']) : null,
                    'placeholder' => isset($data['placeholder']) ? $this->parseValueByFormType($data['placeholder']) : null,
                    'attributes' => isset($data['attributes']) ? $this->parseValueByFormType($data['attributes']) : [],
                    'fieldRootClasses' => array_unique(array_merge($this->commonFieldRootClasses, isset($data['fieldRootClasses']) ? $this->parseValueByFormType($data['fieldRootClasses']) : [])),
                    'fieldRootAttributes' => array_unique(array_merge($this->commonFieldRootAttributes, isset($data['fieldRootAttributes']) ? $this->parseValueByFormType($data['fieldRootAttributes']) : [])),
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

    public function formClasses()
    {
        return [];
    }

    public function formAttributes()
    {
        return [];
    }

    public function submitButtonText()
    {
        return '';
    }

    public function dataRemote()
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
