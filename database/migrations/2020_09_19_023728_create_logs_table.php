<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
			Schema::create('logs', function (Blueprint $table) {
					$table->id();
					$table->string('from');
					$table->string('from_value');
					$table->string('to');
					$table->string('to_value');
					$table->double('amount', 100, 6);
					$table->double('result', 100, 6);
					$table->timestamps();
					$table->string('request_ip');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
			Schema::dropIfExists('logs');
	}
}
