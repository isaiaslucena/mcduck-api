<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ConvertToEuroTest extends TestCase
{
		/**
		 * A basic unit test example.
		 *
		 * @return void
		 */
		public function testIfSumIsCorrect() {
			function sumTwoNumbers($firstNumber, $secondNumber) {
				return $firstNumber + $secondNumber;
			}
			$this->assertEquals(sumTwoNumbers(1, 1), 2);
		}
}
