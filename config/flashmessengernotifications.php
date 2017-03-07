<?php

return [
    'defaultType' => 'info',
    'types' => [
        'info' => [
            'allowDismiss' => true,
            'delay' => 8000,
            'class' => 'info',
            'title' => 'Info',
            'icon' => 'fa fa-check',
            'template' => null,
            'animate' => null,
        ],
        'success' => [
            'allowDismiss' => true,
            'delay' => 8000,
            'class' => 'success',
            'title' => 'Success',
            'icon' => 'fa fa-check',
            'template' => null,
            'animate' => null,
        ],
        'warning' => [
            'allowDismiss' => false,
            'delay' => 12000,
            'class' => 'warning',
            'title' => 'Warning',
            'icon' => 'fa fa-check',
            'template' => null,
            'animate' => null,
        ],
        'danger' => [
            'allowDismiss' => false,
            'delay' => 12000,
            'class' => 'danger',
            'title' => 'Danger',
            'icon' => 'fa fa-check',
            'template' => null,
            'animate' => null,
        ],
    ],
    'defaultAnimate' => [
        'enter' => 'animated fadeInRight',
        'exit' => 'animated fadeOutRight'
    ],
    'defaultTemplate' =>
        '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert">' .
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button>' .
        '<span data-notify="icon"></span> ' .
        '<span data-notify="title" style="font-weight: bold">{1}</span><br>' .
        '<span data-notify="message">{2}</span>' .
        '<div class="progress" data-notify="progressbar">' .
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100" style="width: 0%;">' .
        '</div>' .
        '</div>' .
        '<a href="{3}" target="{4}" data-notify="url"></a>' .
        '</div>',
];
