<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		DB::statement('CREATE EXTENSION IF NOT EXISTS pgcrypto');

		Schema::create('user', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));
			$table->string('fbid', 36)->unique()->nullable();
			$table->string('email')->unique();
			$table->string('name_first');
			$table->string('name_last');

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
		Schema::dropIfExists('user');
	}
}
