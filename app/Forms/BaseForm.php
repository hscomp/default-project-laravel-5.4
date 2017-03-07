<?php

namespace App\Forms;

use App\Exceptions\FormRuleTypeException;
use App\Forms\Contracts\ModelFormInterface;

abstract class BaseForm implements ModelFormInterface
{
    private $url;

    private $submitButtonText;

    private $formClass;

    public function getRules($formType)
    {
        $rules = [];

        foreach ($this->fields() as $rule => $data) {
            if ($formType == 'create' && $data['create']) {
                $rules[$rule] = isset($data['rules']) ? $data['rules'] : [];
            } elseif ($formType == 'edit' && $data['edit']) {
                $rules[$rule] = isset($data['rules']) ? $data['rules'] : [];
            }
        }

        return $rules;
    }

    public function getFields($formType)
    {
        $fields = [];

        foreach ($this->fields() as $rule => $data) {
            if (($formType == 'create' && !$data['create']) || ($formType == 'edit' && !$data['edit'])) {
                continue;
            }
            $fields[$rule] = [
                'fieldType' => $data['fieldType'],
                'name' => $rule,
                'label' => $data['label'],
            ];
        }

        return $fields;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function setSubmitButtonText($submitButtonText)
    {
        $this->submitButtonText = $submitButtonText;

        return $this;
    }

    public function setFormClass($formClass)
    {
        $this->formClass = $formClass;

        return $this;
    }

    public function render($formType, $model = null)
    {
        return view('components.form.renderForm', [
            'class' => $this->formClass,
            'url' => $this->url,
            'formFields' => $this->getFields($formType),
            'submitButtonText' => $this->submitButtonText,
            'model' => $model,
        ])->render();
    }

    public function hasRenderFields($formType)
    {
        return count($this->getFields($formType)) > 0;
    }

}
