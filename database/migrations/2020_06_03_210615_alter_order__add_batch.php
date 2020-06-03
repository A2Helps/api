<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrderAddBatch extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order', function (Blueprint $table) {
			$table->timestamp('complete_at')->nullable();

			$table->boolean('batched')->default(false);
			$table->timestamp('batched_at')->nullable();

			$table->boolean('cards_sent')->default(false);
			$table->timestamp('cards_sent_at')->nullable();
		});

		Schema::table('order_card', function (Blueprint $table) {
			$table->uuid('batch_item_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order', function (Blueprint $table) {
			$table->dropColumn('batched');
			$table->dropColumn('batched_at');
			$table->dropColumn('completed_at');
			$table->dropColumn('cards_sent');
			$table->dropColumn('cards_sent_at');
		});

		Schema::table('order_card', function (Blueprint $table) {
			$table->dropColumn('batch_item_id');
		});
	}
}
