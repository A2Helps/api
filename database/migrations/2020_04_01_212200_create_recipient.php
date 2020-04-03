<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipient extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipient', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->string('phone', 10)->nullable();
			$table->string('name')->nullable();
			$table->uuid('user_id')->nullable();

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
		Schema::dropIfExists('recipient');
	}
}
