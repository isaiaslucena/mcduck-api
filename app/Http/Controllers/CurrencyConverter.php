<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Log;

class CurrencyConverter extends Controller {
	private function mockCurrencyData() {
		return [
			"BTC" => [
					"EUR" => "9200.40",
					"USD" => "10900.20",
					"CHF" => "9800.20",
					"GBP" => "8400.60",
					"TRY" => "82300.20"
			],
			"ETH" => [
					"EUR" => "320.10",
					"USD" => "380.20",
					"CHF" => "350.90",
					"GBP" => "290.30",
					"TRY" => "2600.40"
			]
		];
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

	public function currencyList(Request $request) {
		if ($request->mockData === "true") return response()->json($this->mockCurrencyData());

		$currencyList = Cache::get('currency_list');

		return response()->json(is_null($currencyList) ? $this->saveCurrencyListIntoCache() : $currencyList);
	}

	private function digitalCurrencyExists($digitalCurrency, $request) {
		$cacheResponse = $this->currencyList($request);
		$currencyValuesList = $cacheResponse->original;
		return array_key_exists($digitalCurrency, $currencyValuesList);
	}

	private function isANormalCurrency($currency) {
		$normalCurrencies = ['EUR','USD','CHF','GBP','TRY'];
		return in_array($currency, $normalCurrencies);
	}

	private function getValueOfDigitalCurrency($digitalCurrency, $normalCurrency, $request) {
		$cacheResponse = $this->currencyList($request);
		$currencyValuesList = $cacheResponse->original;
		return $currencyValuesList[$digitalCurrency][$normalCurrency];
	}

	public function currencyConvert(Request $request) {
		$from = strtoupper($request->from);
		$to = strtoupper($request->to);
		$amount = (float) $request->amount;
		$requestIp = $request->ip();

		$message = 'Convert '.$amount.' '.$from.' to '.$to;
		$fromValue = 1;
		$toValue = 1;
		$result = null;
		$statusCode = 500;

		if ($from === $to) $message = "Currency cannot be equal!";
		if (!$this->digitalCurrencyExists($from, $request) && !$this->isANormalCurrency($from)) $message = "Invalid currency at 'from' param!";
		if (!$this->digitalCurrencyExists($to, $request) && !$this->isANormalCurrency($to)) $message = "Invalid currency at 'to' param!";

		if ($this->isANormalCurrency($from) && $this->digitalCurrencyExists($to, $request)) {
			$digitalValue = (float) $this->getValueOfDigitalCurrency($to, $from, $request);
			$result = (float) number_format($amount / $digitalValue, 6, '.', '');
		}

		if ($this->digitalCurrencyExists($from, $request) && $this->isANormalCurrency($to)) {
			$normalValue = (float) $this->getValueOfDigitalCurrency($from, $to, $request);
			$result = (float) number_format($amount * $normalValue, 3, '.', '');
		}

		if ($result && !$request->mockData) {
			$log = new Log;
			$log->from = $from;
			$log->from_value = $this->isANormalCurrency($from) ? number_format(1 / $digitalValue, 6, '.', '') : 1 ;
			$log->to = $to;
			$log->to_value = $this->isANormalCurrency($to) ? $normalValue : 1 ;
			$log->amount = $amount;
			$log->result = $result;
			$log->request_ip = $requestIp;
			$log->save();

			$statusCode = 200;
		}

		return response()->json([
			'message' => $message,
			'result' => $result
		], $statusCode);
	}
}
