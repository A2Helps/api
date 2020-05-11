<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableBatch extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('batch', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->uuid('merchant_id');
			$table->integer('amount');
			$table->integer('quantity');

			$table->uuid('assigned_to')->nullable();
			$table->timestamp('assigned_at')->nullable();

			$table->boolean('completed')->default(false);
			$table->timestamp('completed_at')->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
		});

		Schema::create('batch_item', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->uuid('batch_id');
			$table->string('number');
			$table->uuid('order_card_id')->nullable();
			$table->uuid('card_id')->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('batch_item');
		Schema::dropIfExists('batch');
	}
}
