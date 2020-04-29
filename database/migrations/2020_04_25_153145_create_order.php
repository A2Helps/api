<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrder extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('code', function (Blueprint $table) {
			$table->boolean('redeemed')->default(false);
			$table->timestamp('redeemed_at')->nullable();
		});

		Schema::create('order', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->uuid('code_id');
			$table->uuid('recipient_id');
			$table->uuid('user_id');
			$table->integer('amount');

			$table->boolean('complete')->default(false);

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
		});

		Schema::create('order_card', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->uuid('order_id');
			$table->uuid('recipient_id');

			$table->uuid('merchant_id');
			$table->integer('amount');

			$table->uuid('card_id')->nullable()->unique();

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
		});

		Schema::create('card', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->uuid('merchant_id');
			$table->integer('amount');
			$table->string('number');
			$table->boolean('assigned')->default(false);
			$table->uuid('order_card_id')->nullable();
			$table->uuid('recipient_id')->nullable();

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
		Schema::dropIfExists('order');
		Schema::dropIfExists('order_card');
		Schema::dropIfExists('card');

		Schema::table('code', function (Blueprint $table) {
			$table->dropColumn('redeemed');
			$table->dropColumn('redeemed_at');
		});
	}
}
