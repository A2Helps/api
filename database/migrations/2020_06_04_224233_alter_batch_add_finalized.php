<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBatchAddFinalized extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('batch', function (Blueprint $table) {
			$table->boolean('finalized')->default(false);
			$table->timestamp('finalized_at')->nullable();
		});

		Schema::table('order', function (Blueprint $table) {
			$table->boolean('finalized')->default(false);
			$table->timestamp('finalized_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('batch', function (Blueprint $table) {
			$table->dropColumn('finalized_at');
			$table->dropColumn('finalized');
		});

		Schema::table('order', function (Blueprint $table) {
			$table->dropColumn('finalized_at');
			$table->dropColumn('finalized');
		});
	}
}
