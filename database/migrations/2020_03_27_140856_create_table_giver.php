<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableGiver extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('giver', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->string('name');

			$table->integer('allotment')->default(0);
			$table->integer('count_given')->defualt(0);
			$table->boolean('enabled')->default(false);

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
		});

		Schema::create('giver_user', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->uuid('giver_id');
			$table->uuid('user_id');

			$table->integer('allotment')->default(0);
			$table->integer('count_given')->defualt(0);
			$table->boolean('enabled')->default(false);

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
			$table->unique(['giver_id', 'user_id'], 'uniq_giver_user');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('giver_user');
		Schema::dropIfExists('giver');
	}
}
