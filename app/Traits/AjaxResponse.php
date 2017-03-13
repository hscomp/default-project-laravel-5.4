<?php

namespace App\Traits;

trait AjaxResponse
{
    protected $_alert = null;

    protected $_notifications = [];

    public function ajaxAlert($data, $driver = null)
    {
        $driver = $driver ?: config('flashmessengeralerts.driver');

        $alertData = [];

        if ($driver == 'swal') {
            $alertData['title'] = $data['title'];
            $alertData['text'] = $data['text'];
            $alertData['type'] = isset($data['type']) ? $data['type'] : 'success';
            $alertData['confirmButtonText'] = isset($data['confirmButtonText']) ? $data['confirmButtonText'] : 'Ok';
        } elseif ($driver == 'vex') {
            $alertData['unsafeContent'] = '<strong>' . $data['title'] . '</strong><br>' . $data['text'];
        }

        $this->_alert = [
            'driver' => $driver,
            'data' => $alertData
        ];

        return $this;
    }

    public function ajaxNotification($notification)
    {
        $this->_notifications[] = $notification;

        return $this;
    }

    public function ajaxResponse($data = null, $redirect = false)
    {
        return response()->json(
            [
                'ajaxResponse' => [
                    'alert' => $this->_alert,
                    'notifications' => $this->_notifications,
                    'redirect' => $redirect,
                    'data' => $data,
                ]
            ]
        );
    }

}