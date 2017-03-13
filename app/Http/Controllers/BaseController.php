<?php

namespace App\Http\Controllers;

//use App\Helpers\Helper;
//use JavaScript;

use App\Traits\AjaxResponse;
use App\Traits\Notifiable;

class BaseController extends Controller {

    use Notifiable, AjaxResponse;

	public function __construct() {
//		if (session('javascriptFlash')) {
//			Helper::javascriptFlash(session('javascriptFlash')['message'], session('javascriptFlash')['type']);
//		}
//
//		JavaScript::put(['jstranslations' => trans('jstranslations')]);
//		JavaScript::put(['tournament_default_deaddline_before_start' => config('tournament.default_deadline_before_start')]);
	}

}
