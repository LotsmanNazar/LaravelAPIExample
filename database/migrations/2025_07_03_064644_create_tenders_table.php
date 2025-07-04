<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('tenders', function (Blueprint $table) {
			$table->id();
			$table->string('external_code');
			$table->string('number');
			$table->string('status');
			$table->string('name');
			$table->timestamp('change_date')->useCurrent()->index();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('tenders');
	}
};
