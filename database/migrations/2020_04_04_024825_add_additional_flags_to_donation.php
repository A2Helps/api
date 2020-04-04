<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFlagsToDonation extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('donation', function (Blueprint $table) {
			$table->boolean('public')->default(false);
			$table->string('public_name')->nullable();

			$table->boolean('wired')->default(false);
			$table->string('wired_from')->nullable();

			$table->boolean('settled')->default(false);
			$table->timestamp('settled_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('donation', function (Blueprint $table) {
			$table->dropColumn('settled_at');
			$table->dropColumn('settled');
			$table->dropColumn('wired_from');
			$table->dropColumn('wired');
			$table->dropColumn('public_name');
			$table->dropColumn('public');
		});
	}
}
