<?php

namespace App\Traits;

use App\Helpers\Helper;
use App\Utilities\FlashMessenger;

trait Notifiable
{
    /**
     * Send javascript alert to output
     * @param type $alert - key in recources/lang/flash.php
     * @param bool $flash
     * @param array $vars
     * @return $this
     */
    public function sendAlert($alert, $flash = true, $vars = [])
    {
        $allowedTypes = app()->make(FlashMessenger::class)->getAlertTypes();

        $type = isset($alert['type']) ? $alert['type'] : 'success';

        $type = in_array($type, $allowedTypes) ? $type : 'success';

        $title = isset($alert['title']) ? $alert['title'] : '';
        $text = isset($alert['text']) ? $alert['text'] : '';

        app()->make(FlashMessenger::class)->alert([
            'type' => $type,
            'title' => Helper::assignVars($title, $vars),
            'text' => Helper::assignVars($text, $vars),
            'confirmButtonText' => 'OK'
        ], $flash);

        return $this;
    }

    /**
     * Send javascript alert to output
     * @param type $notification - key in recources/lang/flash.php
     * @param array $vars
     * @return $this
     */
    public function sendNotification($notification, $flash = true, $vars = [])
    {
        $allowedTypes = app()->make(FlashMessenger::class)->getNotificationTypes();

        $type = isset($notification['type']) ? $notification['type'] : 'success';

        $type = in_array($type, $allowedTypes) ? $type : 'success';

        $title = isset($notification['title']) ? $notification['title'] : '';
        $text = isset($notification['text']) ? $notification['text'] : '';

        app()->make(FlashMessenger::class)->notification([
            'type' => $type,
            'title' => Helper::assignVars($title, $vars),
            'text' => Helper::assignVars($text, $vars),
        ], $flash);

        return $this;
    }

}
