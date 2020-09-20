<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;

class LogController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$lastTwentyLogs = Log::orderBy('created_at', 'DESC')->get()->take(20);

		return response()->json($lastTwentyLogs);
	}
}
