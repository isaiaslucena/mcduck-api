<?php

namespace Database\Factories;

use App\Log;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LogFactory extends Factory {
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Log::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition() {
		return [
			'from' => 'EUR',
			'from_value' => '9200.40',
			'to' => 'BTC',
			'to_value' => '1',
			'amount' => 10000,
			'result' => 1.086909,
			'created_at' => '2020-09-18 15:32:12',
			'request_ip' => '127.0.0.1',
		];
	}
}
