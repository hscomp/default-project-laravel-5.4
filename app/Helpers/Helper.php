<?php

namespace App\Helpers;

use Carbon\Carbon;
use Html;
use JavaScript;

class Helper
{
    public static function getPhoneValidation()
    {
        return [
            'required',
            'min:8',
            'max:22',
            'regex:/^(\+|[0-9]){1}([0-9\-\s]){6,20}([0-9])$/',
        ];
    }

    public static function set_active_by_url($path, $byRoute = true, $active = 'active')
    {
        return $byRoute
        ? (request()->route() == $path ? $active : '')
        : (request()->is($path) == $path ? $active : '');

    }

    public static function set_active_by_route($route, $active = 'active')
    {
        return request()->route()->getName() == $route ? $active : '';
    }

    public static function set_active_by_segment($name, $segment = 1, $active = 'active')
    {
        return request()->segment($segment) == $name ? $active : '';
    }

    public static function set_active_by_segments($url, $exact = false, $active = 'active')
    {
        $isActive = true;

        $segments = explode('/', $url);

        if ($exact && count(request()->segments()) > count($segments)) {
            return '';
        }

        foreach ($segments as $segment => $text) {

            $currentSegment = request()->segment($segment + 1);

            if (str_contains($text, '{') && str_contains($text, '}')) {
                $param = substr($text, 1, strpos($text, '}') - 1);

                $model = \Route::current()->getParameter($param);
                if (!$model || $model->slug != $currentSegment) {
                    $isActive = false;
                    break;
                }
            } else {
                if (!($currentSegment == $text)) {
                    $isActive = false;
                    break;
                }
            }
        }

        return $isActive ? $active : '';
    }

    public static function date($date, array $options = [], $onlyTime = false)
    {
        if (!$date) {
            return '';
        }

        $defaultOptions = [
            'fullDate' => true,
            'twoRows' => false,
            'dateFormat' => 'F j Y',
            'timeFormat' => 'h:i A',
            'withNbsp' => true,
        ];

        $options = array_replace($defaultOptions, $options);

        if ($date == '0000-00-00 00:00:00') {
            return '-';
        }

        if (is_string($date)) {
            $carbonDate = Carbon::createFromFormat('Y-m-d', $date);
        } else {
            $carbonDate = $date;
        }

        $date = $carbonDate->format($options['dateFormat']);

        $time = $carbonDate->format($options['timeFormat']);

        if ($onlyTime) {
            return $time;
        }

        if ($options['fullDate']) {
            if ($options['twoRows']) {
                $finalDate = $date . '<br>' . $time;
            } else {
                $finalDate = $date . ' ' . $time;
            }
        } else {
            $finalDate = $date;
        }

        return str_replace(' ', $options['withNbsp'] ? '&nbsp;' : '', $finalDate);
    }

    public static function javascriptFlash($message, $type = 'success')
    {
        JavaScript::put([
            'flashMessage' => [
                'type' => $type,
                'message' => $message,
            ],
        ]);
    }

    public static function sessionFlash($message, $type = 'success')
    {
        request()->session()->flash('javascriptFlash',
            ['type' => 'success', 'message' => 'Team registration was successful.']);
    }

    /**
     * https://robohash.org/
     *
     * @param $text
     * @param array $urlOptions
     * @param array $imageTagOptions
     * @param null $alt
     * @return \Illuminate\Support\HtmlString
     * @internal param array $options
     * @internal param string $size
     */
    public static function robotImg($text, $urlOptions = [], $imageTagOptions = [], $alt = null)
    {
        $defaultUrlOptions = [
            'set' => 'set1', // set1 - set3
            'size' => '80x80',
            'extension' => 'png',
            'bgset' => null, // bg1 - bg2
        ];

        $urlOptions = array_replace($defaultUrlOptions, $urlOptions);

        $defaultImageTagOptions = [
            'width' => substr($urlOptions['size'], 0, strpos($urlOptions['size'], 'x')),
            'height' => substr($urlOptions['size'], strpos($urlOptions['size'], 'x') + 1),
        ];

        $imageTagOptions = array_replace($defaultImageTagOptions, $imageTagOptions);

        $urlParams[] = 'size=' . $urlOptions['size'];
        $urlParams[] = 'set=' . $urlOptions['set'];

        if ($urlOptions['bgset']) {
            $urlParams[] = 'bgset=' . $urlOptions['bgset'];
        }

        $url = 'https://robohash.org/' . $text . '.' . $defaultUrlOptions['extension'];

        if (count($urlParams)) {
            $url .= '?' . implode('&', $urlParams);
        }

        return Html::image($url, $alt, $imageTagOptions);
    }

    /**
     * Substitutes variables {variable} in text: Replace this {variable}
     *
     * @param type $text
     * @param type $vars
     * @return type|mixed
     */
    public static function assignVars($text, $vars = [])
    {
        foreach ($vars as $key => $var) {
            $text = str_replace("{" . $key . "}", $var, $text);
        }
        return $text;
    }

    static function formatAmount($amount, Array $options = [])
    {
        $defaultOptions = [
            'strong' => false,
            'symbol' => '$',
            'color' => null,
            'colorByPositiveNegative' => false,
            'strongIfNonzero' => false,
            'dashIfZero' => false,
            'lineThrough' => false,
        ];

        $amount = round($amount, 10);

        if ($amount == -0)
        {
            $amount = 0;
        }

        $options = array_replace($defaultOptions, $options);

        if ($options['dashIfZero'] && $amount == 0)
        {
            return '-';
        }

        if ($options['strongIfNonzero'] && ($amount < 0 || $amount > 0))
        {
            $options['strong'] = true;
        }

        $formatedAmount = number_format($amount, 2, ',', ' ');

        if ($options['lineThrough']) {
            $formatedAmount = '<del>' . $formatedAmount . '</del>';
        }

        $formatedAmount = in_array($options['symbol'], ['$'])
            ? $options['symbol'] . $formatedAmount
            : $formatedAmount . ' ' . $options['symbol'];

        $formatedAmount = str_replace(' ', '&nbsp;', $formatedAmount);

        if ($options['color'] != null)
        {
            $formatedAmount = '<span class="app-color-' . $options['color'] . '">' . $formatedAmount . '</span>';
        }
        elseif ($options['colorByPositiveNegative'] && $amount != 0)
        {
            $formatedAmount = $amount < 0
                ? '<span class="app-color-red">' . $formatedAmount . '</span>'
                : '<span class="app-color-green">' . $formatedAmount . '</span>';
        }

        if ($options['strong'])
        {
            $formatedAmount = '<strong>' . $formatedAmount . '</strong>';
        }

        return $formatedAmount;
    }

}
