<?php
namespace App\Utilities;

use Illuminate\Support\Facades\Session;
use JavaScript;

class FlashMessenger
{
    private $notificationsConfig;

    private $alertsConfig;

    private $notifications = [];

    private $alerts = [];

    public function __construct($notificationsConfig = [], $alertsConfig = [])
    {
        $this->notificationsConfig = $this->createNotificationsConfig($notificationsConfig);

        $this->alertsConfig = $this->createAlertsConfig($alertsConfig);
    }

    public function notification($data, $flash = true)
    {
        $notification = [
            'type' => isset($data['type']) ? $data['type'] : $this->notificationsConfig['defaultType'],
            'title' => isset($data['title']) ? $data['title'] : null,
            'text' => $data['text'],
            'options' => isset($data['options']) ? $data['options'] : null,
        ];

        if ($flash) {
            request()->session()->push('flash_notifications', $notification);
        } else {
            $this->notifications[] = $notification;
        }
    }

    public function alert($data, $flash = true)
    {
        $alert = [
            'type' => isset($data['type']) ? $data['type'] : $this->alertsConfig['defaultType'],
            'title' => isset($data['title']) ? $data['title'] : null,
            'text' => $data['text'],
            'options' => isset($data['options']) ? $data['options'] : null,
            'confirmButtonText' => isset($data['confirmButtonText']) ? $data['confirmButtonText'] : $this->alertsConfig['defaultConfirmButtonText'],
        ];

        if ($flash) {
            request()->session()->push('flash_alerts', $alert);
        } else {
            $this->alerts[] = $alert;
        }
    }

    public function infoNotification($text, $title = null)
    {
        $this->notification([
            'type' => 'info',
            'title' => $title,
            'text' => $text,
        ]);
    }

    public function handle()
    {
        $notifications = Session::get('flash_notifications');

        $alerts = Session::get('flash_alerts');

        if ($notifications) {
            Session::forget('flash_notifications');
        }

        if ($alerts) {
            Session::forget('flash_alerts');
        }

        if ($notifications) {
            foreach ($notifications as $notification) {
                $this->notifications[] = $notification;
            }
        }

        if ($alerts) {
            foreach ($alerts as $alert) {
                $this->alerts[] = $alert;
            }
        }
    }

    public function sendToJavascript()
    {
        JavaScript::put([
            'flashMessenger' => [
                'notificationsConfig' => $this->notificationsConfig,
                'notifications' => $this->notifications,
                'alertsConfig' => $this->alertsConfig,
                'alerts' => $this->alerts,
            ],
        ]);
    }

    /**
     * Create messenger notifications configuration.
     *
     * @param $notificationsConfig
     * @return array
     */
    private function createNotificationsConfig($notificationsConfig)
    {
        $defaultConfig = [
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
                    'icon' => 'fa fa-warning',
                    'template' => null,
                    'animate' => null,
                ],
                'danger' => [
                    'allowDismiss' => false,
                    'delay' => 12000,
                    'class' => 'danger',
                    'title' => 'Danger',
                    'icon' => 'fa fa-warning',
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
                '<span data-notify="title">{1}</span> ' .
                '<span data-notify="message">{2}</span>' .
                '<div class="progress" data-notify="progressbar">' .
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 0%;">' .
                '</div>' .
                '</div>' .
                '<a href="{3}" target="{4}" data-notify="url"></a>' .
                '</div>',
        ];

        return array_replace($notificationsConfig, $defaultConfig);
    }

    /**
     * Create messenger alerts configuration.
     *
     * @param $alertsConfig
     * @return array
     */
    private function createAlertsConfig($alertsConfig)
    {
        $defaultConfig = [
            'defaultType' => 'success',
            'defaultConfirmButtonText' => 'Ok',
            'types' => [
                'info' => [
                    'confirmButtonText' => 'Ok 2',
                ],
                'success' => [
                    'confirmButtonText' => 'Ok 3',
                ],
                'warning' => [
                    'confirmButtonText' => 'Ok 4',
                ],
                'error' => [
                    'confirmButtonText' => 'Ok 5',
                ],
                'question' => [
                    'confirmButtonText' => 'Ok 6',
                ],
            ],
        ];

        return array_replace($alertsConfig, $defaultConfig);
    }

    public function getAlertTypes()
    {
        return array_keys($this->alertsConfig['types']);
    }

    public function getNotificationTypes()
    {
        return array_keys($this->notificationsConfig['types']);
    }
}