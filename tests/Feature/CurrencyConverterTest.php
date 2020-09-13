<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyConverterTest extends TestCase
{
	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfReturnCurrencyValuesList() {
		$response = $this->get('/api/currencyList');
		$currencyValuesList = $response->json();

		$response->assertStatus(200);
		$this->assertCount(38, $currencyValuesList);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfConverterIsReturningCorrectValue() {
		$convertedCurrency = (object) $this->get('/api/currencyConvert?amount=20')->json();

		$this->assertEquals(20, $convertedCurrency->amount);
	}
}
