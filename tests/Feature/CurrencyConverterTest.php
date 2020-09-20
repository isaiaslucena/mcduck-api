<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyConverterTest extends TestCase {
	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfResponseOfCurrencyValuesListIsOk() {
		$response = $this->get('/api/currencyList?mockData=true');
		$response->assertStatus(200);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfReturnCurrencyValuesListNotEmpty() {
		$this->withoutExceptionHandling();

		$response = $this->get('/api/currencyList?mockData=true');
		$currencyValuesList = $response->json();
		$this->assertCount(2, $currencyValuesList);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfReturnInvalidWhenCurrenciesArEqual() {
		$this->withoutExceptionHandling();

		$response = $this->get('/api/currencyConvert?from=usd&to=usd&amount=24&mockData=true');
		$response->assertStatus(500);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfReturnInvalidCurrencyOfFromParam() {
		$this->withoutExceptionHandling();

		$response = $this->get('/api/currencyConvert?from=usdol&to=btc&amount=24&mockData=true');
		$response->assertStatus(500);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfReturnInvalidCurrencyOfToParam() {
		$this->withoutExceptionHandling();

		$response = $this->get('/api/currencyConvert?from=usd&to=ethrthum&amount=24&mockData=true');
		$response->assertStatus(500);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfConvertFromEurToBtcIsCorrect() {
		$this->withoutExceptionHandling();

		$convertedCurrency = $this->get('/api/currencyConvert?from=eur&to=btc&amount=10000&mockData=true')->json();

		$this->assertEquals(1.086909, $convertedCurrency['result']);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfConvertFromEurToEthIsCorrect() {
		$this->withoutExceptionHandling();

		$convertedCurrency = $this->get('/api/currencyConvert?from=eur&to=eth&amount=10000&mockData=true')->json();

		$this->assertEquals(31.240237, $convertedCurrency['result']);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfConvertFromUsdToBtcIsCorrect() {
		$this->withoutExceptionHandling();

		$convertedCurrency = $this->get('/api/currencyConvert?from=usd&to=btc&amount=240000&mockData=true')->json();

		$this->assertEquals(22.017945, $convertedCurrency['result']);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfConvertFromUsdToEthIsCorrect() {
		$this->withoutExceptionHandling();

		$convertedCurrency = $this->get('/api/currencyConvert?from=usd&to=eth&amount=12000&mockData=true')->json();

		$this->assertEquals(31.562336, $convertedCurrency['result']);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfConvertFromBtcToEurIsCorrect() {
		$this->withoutExceptionHandling();

		$convertedCurrency = $this->get('/api/currencyConvert?from=btc&to=eur&amount=2&mockData=true')->json();

		$this->assertEquals(18400.8, $convertedCurrency['result']);
	}

	/**
	 * A basic test.
	 *
	 * @return void
	 */
	public function testIfConvertFromBtcToUsdIsCorrect() {
		$this->withoutExceptionHandling();

		$convertedCurrency = $this->get('/api/currencyConvert?from=btc&to=usd&amount=2&mockData=true')->json();

		$this->assertEquals(21800.4, $convertedCurrency['result']);
	}
}
