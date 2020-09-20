<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Log;

class LogConvertedCurrenciesTest extends TestCase {
	use RefreshDatabase;

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfCanInsertLogRegistry() {
		$this->withoutExceptionHandling();

		Log::factory()->create();

    $this->assertDatabaseHas('logs', [
			'id' => 1,
			'from' => 'EUR',
			'from_value' => '9200.40',
			'to' => 'BTC',
			'to_value' => '1',
			'amount' => 10000,
			'result' => 1.086909,
			'created_at' => '2020-09-18 15:32:12',
			'request_ip' => '127.0.0.1',
    ]);
	}

	public function testIfReturnLastTwentyConvertedCurrencies() {
		$this->withoutExceptionHandling();

		Log::factory()->count(30)->create();

		$response = $this->get('/api/showConvertOperations');
		$lastTwentyLogs = $response->json();
		$this->assertCount(20, $lastTwentyLogs);
	}
}
