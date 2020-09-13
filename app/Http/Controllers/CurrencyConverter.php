<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyConverter extends Controller {
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function __invoke(Request $request) {
		return response()->json($request);
	}

	private function getCurrencyListFromBitPanda() {
		$response = Http::get('https://api.bitpanda.com/v1/ticker');

		return $response->json();
	}

	private function saveCurrencyListIntoCache() {
		$seconds = 600;
		Cache::put('currency_list', $this->getCurrencyListFromBitPanda(), $seconds);
		return Cache::get('currency_list');
	}

	/**
	 * get last currency values
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function currencyList() {
		$currencyList = Cache::get('currency_list');

		return response()->json(is_null($currencyList) ? $this->saveCurrencyListIntoCache() : $currencyList);
	}

	/**
	 * convert from one currency to another
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function currencyConvert(Request $request) {
		$from = $request->from;
		$to = $request->to;
		$amount = (int) $request->amount;

		$currencyList = $this->currencyList();

		return response()->json(['amount' => $amount]);
	}
}
